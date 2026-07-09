<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Models\System\RoleAssignmentLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        $filters = [];

        if ($request->filled('role')) {
            $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
            $filters['role'] = $request->role;
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
            $filters['city'] = $request->city;
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
            $filters['status'] = $request->status;
        }

        $users = $query->paginate(15)->withQueryString();

        return view('dashboard.admin.users.index', compact('users', 'filters'));
    }

    public function create()
    {
        return view('dashboard.admin.users.create');
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'city' => $request->city,
            'status' => UserStatus::from($request->status),
        ]);

        $user->assignRole($request->role);

        RoleAssignmentLog::create([
            'admin_id' => Auth::id(),
            'user_id' => $user->id,
            'old_role' => 'N/A',
            'new_role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User account created successfully.');
    }

    public function details($id)
    {
        $user = User::with(['roles', 'babysitterProfile', 'doctorProfile'])->findOrFail($id);

        return view('dashboard.admin.users.details', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return view('dashboard.admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'status' => 'required|in:active,suspended,banned',
        ]);

        $user = User::findOrFail($id);
        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function suspend($id)
    {
        $user = User::findOrFail($id);
        $oldStatus = $user->status->value;
        $user->update(['status' => UserStatus::Suspended]);

        RoleAssignmentLog::create([
            'admin_id' => Auth::id(),
            'user_id' => $user->id,
            'old_role' => $oldStatus,
            'new_role' => UserStatus::Suspended->value,
        ]);

        $user->notify(new \App\Notifications\AccountSuspended());

        return redirect()->back()->with('success', 'User suspended successfully.');
    }

    public function ban(Request $request, $id)
    {
        $data = $request->validate([
            'reason' => 'required|string|max:500',
            'duration' => 'nullable|integer|min:1',
        ]);

        $user = User::findOrFail($id);
        $updates = ['status' => UserStatus::Banned];

        if ($request->filled('duration')) {
            $updates['banned_until'] = now()->addDays($request->duration);
        }

        $user->update($updates);
        $user->ban_reason = $data['reason'];
        $user->save();

        return redirect()->back()->with('success', 'User banned successfully.');
    }

    public function restore($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => UserStatus::Active]);

        return redirect()->back()->with('success', 'User restored successfully.');
    }

    public function destroy($id)
    {
        if ((int) $id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
