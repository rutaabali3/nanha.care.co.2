<?php

namespace App\Http\Controllers\Dashboard\Parent;

use App\Models\Babysitting\Child;
use Illuminate\Http\Request;

class ChildrenController
{
    public function index()
    {
        $children = Child::where('parent_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('dashboard.parent.children.index', compact('children'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'allergies' => 'nullable|string|max:1000',
            'special_needs' => 'nullable|string|max:1000',
        ]);

        $allergies = ! empty($validated['allergies'])
            ? array_map('trim', explode(',', $validated['allergies']))
            : [];

        Child::create([
            'parent_id' => auth()->id(),
            'name' => $validated['name'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'allergies' => $allergies,
            'special_needs' => $validated['special_needs'] ?? null,
        ]);

        return redirect()->route('parent.children.index')
            ->with('success', 'Child added successfully.');
    }

    public function update(Request $request, $id)
    {
        $child = Child::where('parent_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'allergies' => 'nullable|string|max:1000',
            'special_needs' => 'nullable|string|max:1000',
        ]);

        $allergies = ! empty($validated['allergies'])
            ? array_map('trim', explode(',', $validated['allergies']))
            : [];

        $validated['allergies'] = $allergies;

        $child->update($validated);

        return redirect()->route('parent.children.index')
            ->with('success', 'Child updated successfully.');
    }

    public function destroy($id)
    {
        $child = Child::where('parent_id', auth()->id())->findOrFail($id);
        $child->delete();

        return redirect()->route('parent.children.index')
            ->with('success', 'Child removed successfully.');
    }
}
