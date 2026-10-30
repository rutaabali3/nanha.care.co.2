<?php

namespace App\Services;

use App\Contracts\IEmailService;
use App\Contracts\ISupportTicketService;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Support\SupportTicket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupportTicketService implements ISupportTicketService
{
    public function __construct(
        private IEmailService $email,
    ) {}

    public function getAll(array $filters): LengthAwarePaginator
    {
        $query = SupportTicket::with('user', 'agent');

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('subject', 'like', '%'.$filters['search'].'%')
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', '%'.$filters['search'].'%'));
            });
        }

        return $query->orderByDesc('created_at')->paginate(15);
    }

    public function getById(int $id): SupportTicket
    {
        return SupportTicket::with('user', 'agent', 'replies.user')->findOrFail($id);
    }

    public function create(array $data, string $userId): SupportTicket
    {
        return SupportTicket::create([
            'user_id' => $userId,
            'subject' => $data['subject'],
            'status' => TicketStatus::New,
            'priority' => $data['priority'] ?? TicketPriority::Medium,
        ]);
    }

    public function reply(int $id, string $content, string $agentId, bool $isInternal = false): void
    {
        $ticket = SupportTicket::findOrFail($id);

        $ticket->replies()->create([
            'user_id' => $agentId,
            'content' => $content,
            'is_internal_note' => $isInternal,
        ]);

        if ($ticket->status === TicketStatus::New) {
            $ticket->update(['status' => TicketStatus::Open]);
        }

        if (! $isInternal) {
            $this->email->sendContactReply($ticket->id);
        }
    }

    public function assign(int $id, string $agentId): void
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->update([
            'assigned_to' => $agentId,
            'status' => TicketStatus::InProgress,
        ]);
    }

    public function escalate(int $id): void
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->update([
            'status' => TicketStatus::Escalated,
            'priority' => TicketPriority::High,
        ]);
    }

    public function close(int $id, string $agentId): void
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->update([
            'status' => TicketStatus::Closed,
            'assigned_to' => $agentId,
        ]);
    }
}
