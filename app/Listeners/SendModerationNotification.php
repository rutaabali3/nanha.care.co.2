<?php

namespace App\Listeners;

use App\Contracts\INotificationService;
use App\Events\BlogPostSubmitted;
use App\Events\ProductSubmitted;

class SendModerationNotification
{
    public function __construct(private INotificationService $notificationService) {}

    public function handleProductSubmitted(ProductSubmitted $event): void
    {
        $this->notificationService->broadcast(
            ['moderator'],
            'New product pending review: '.($event->product->name ?? 'Unknown')
        );
    }

    public function handleBlogPostSubmitted(BlogPostSubmitted $event): void
    {
        $this->notificationService->broadcast(
            ['moderator'],
            'New blog post pending review: '.($event->post->title ?? 'Unknown')
        );
    }

    public function subscribe($events): void
    {
        $events->listen(ProductSubmitted::class, [self::class, 'handleProductSubmitted']);
        $events->listen(BlogPostSubmitted::class, [self::class, 'handleBlogPostSubmitted']);
    }
}
