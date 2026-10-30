<?php

namespace App\Http\Controllers\Dashboard\Support;

use App\Contracts\ISupportTicketService;
use App\Http\Requests\Support\TicketReplyRequest;
use App\Models\Support\ReplyTemplate;
use Illuminate\Http\Request;

class TicketsController
{
    public function __construct(
        protected ISupportTicketService $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'priority', 'date_from', 'date_to']);

        $tickets = $this->service->getAll($filters);

        return view('dashboard.support.tickets.index', compact('tickets', 'filters'));
    }

    public function details($id)
    {
        $ticket = $this->service->getById($id);
        $ticket->load(['replies.user']);

        $templates = ReplyTemplate::all();

        return view('dashboard.support.tickets.details', compact('ticket', 'templates'));
    }

    public function reply(TicketReplyRequest $request, $id)
    {
        $this->service->reply(
            $id,
            $request->input('content'),
            auth()->id(),
            $request->boolean('is_internal_note')
        );

        return redirect()->back()->with('success', 'Reply added successfully.');
    }

    public function assign(Request $request, $id)
    {
        $request->validate([
            'agent_id' => ['required', 'exists:users,id'],
        ]);

        $this->service->assign($id, $request->input('agent_id'));

        return redirect()->back()->with('success', 'Ticket assigned successfully.');
    }

    public function bulkClose(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:support_tickets,id',
        ]);

        foreach ($request->input('ids') as $id) {
            $this->service->close((int) $id, auth()->id());
        }

        return redirect()->back()->with('success', 'Selected tickets closed.');
    }

    public function bulkReassign(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:support_tickets,id',
            'agent_id' => ['required', 'exists:users,id'],
        ]);

        foreach ($request->input('ids') as $id) {
            $this->service->assign((int) $id, $request->input('agent_id'));
        }

        return redirect()->back()->with('success', 'Selected tickets reassigned.');
    }
}
