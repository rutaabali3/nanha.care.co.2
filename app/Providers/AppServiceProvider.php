<?php

namespace App\Providers;

use App\Contracts\IBabysitterService;
use App\Contracts\IBlogService;
use App\Contracts\IBookingService;
use App\Contracts\IDashboardService;
use App\Contracts\IEmailService;
use App\Contracts\IFileUploadService;
use App\Contracts\IMarketplaceService;
use App\Contracts\IModerationService;
use App\Contracts\INotificationService;
use App\Contracts\IOnboardingService;
use App\Contracts\IOrderService;
use App\Contracts\IPaymentService;
use App\Contracts\IProductService;
use App\Contracts\ISupportTicketService;
use App\Services\BabysitterService;
use App\Services\BlogService;
use App\Services\BookingService;
use App\Services\DashboardService;
use App\Services\EmailService;
use App\Services\FileUploadService;
use App\Services\MarketplaceService;
use App\Services\ModerationService;
use App\Services\NotificationService;
use App\Services\OnboardingService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\ProductService;
use App\Services\SupportTicketService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IBabysitterService::class, BabysitterService::class);
        $this->app->singleton(IBookingService::class, BookingService::class);
        $this->app->singleton(IMarketplaceService::class, MarketplaceService::class);
        $this->app->singleton(IProductService::class, ProductService::class);
        $this->app->singleton(IOrderService::class, OrderService::class);
        $this->app->singleton(IBlogService::class, BlogService::class);
        $this->app->singleton(INotificationService::class, NotificationService::class);
        $this->app->singleton(IEmailService::class, EmailService::class);
        $this->app->singleton(IFileUploadService::class, FileUploadService::class);
        $this->app->singleton(ISupportTicketService::class, SupportTicketService::class);
        $this->app->singleton(IModerationService::class, ModerationService::class);
        $this->app->singleton(IDashboardService::class, DashboardService::class);
        $this->app->singleton(IPaymentService::class, PaymentService::class);
        $this->app->singleton(IOnboardingService::class, OnboardingService::class);
    }

    public function boot(): void
    {
        //
    }
}
