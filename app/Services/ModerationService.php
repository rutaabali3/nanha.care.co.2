<?php

namespace App\Services;

use App\Contracts\IModerationService;
use App\Contracts\INotificationService;
use App\Enums\ContentStatus;
use App\Models\Blog\BlogPost;
use App\Models\Marketplace\Product;
use App\Models\Profiles\BabysitterProfile;
use App\Models\System\FlaggedItem;
use App\Models\System\ModerationLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ModerationService implements IModerationService
{
    private array $typeMap = [
        'blog_post' => BlogPost::class,
        'product' => Product::class,
        'babysitter_profile' => BabysitterProfile::class,
    ];

    public function __construct(
        private INotificationService $notification,
    ) {}

    public function getQueue(?string $type = null): Collection
    {
        $result = collect();

        $types = $type ? (isset($this->typeMap[$type]) ? [$type => $this->typeMap[$type]] : []) : $this->typeMap;

        foreach ($types as $key => $class) {
            $items = $class::where('status', ContentStatus::UnderReview)->get()->map(
                fn ($item) => ['type' => $key, 'item' => $item]
            );
            $result = $result->concat($items);
        }

        return $result;
    }

    public function approve(string $type, int $id, string $moderatorId): void
    {
        $model = $this->resolve($type, $id);
        $model->update([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        ModerationLog::create([
            'moderator_id' => $moderatorId,
            'action' => 'approved',
            'target_type' => $type,
            'target_id' => $id,
            'submitted_at' => now(),
            'reviewed_at' => now(),
        ]);
    }

    public function reject(string $type, int $id, string $reason, string $moderatorId): void
    {
        $model = $this->resolve($type, $id);
        $model->update(['status' => ContentStatus::Rejected]);

        ModerationLog::create([
            'moderator_id' => $moderatorId,
            'action' => 'rejected',
            'target_type' => $type,
            'target_id' => $id,
            'reason' => $reason,
            'submitted_at' => now(),
            'reviewed_at' => now(),
        ]);
    }

    public function requestRevision(string $type, int $id, string $note, string $moderatorId): void
    {
        $model = $this->resolve($type, $id);
        $model->update(['status' => ContentStatus::Draft]);

        ModerationLog::create([
            'moderator_id' => $moderatorId,
            'action' => 'revision_requested',
            'target_type' => $type,
            'target_id' => $id,
            'reason' => $note,
            'submitted_at' => now(),
            'reviewed_at' => now(),
        ]);
    }

    public function getPublished(?string $type = null): LengthAwarePaginator
    {
        $class = $this->typeMap[$type] ?? BlogPost::class;

        return $class::where('status', ContentStatus::Published)
            ->orderByDesc('created_at')
            ->paginate(15);
    }

    public function getFlagged(): LengthAwarePaginator
    {
        return FlaggedItem::with('reporter', 'flaggable')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->paginate(15);
    }

    public function dismissFlag(int $id): void
    {
        FlaggedItem::findOrFail($id)->update(['status' => 'dismissed']);
    }

    public function escalateFlag(int $id): void
    {
        FlaggedItem::findOrFail($id)->update(['status' => 'escalated']);
    }

    private function resolve(string $type, int $id): mixed
    {
        $class = $this->typeMap[$type] ?? throw new \InvalidArgumentException("Unknown type: {$type}");

        return $class::findOrFail($id);
    }
}
