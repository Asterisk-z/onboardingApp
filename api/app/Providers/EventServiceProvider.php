<?php

namespace App\Providers;

use App\Events\ApplicationSubmissionEvent;
use App\Events\ArAddedEvent;
use App\Events\ESuccessLetterEvent;
use App\Events\FinalApplicationProcessingEvent;
use App\Events\MembershipAgreementLetterEvent;
use App\Listeners\ApplicationSubmissionListener;
use App\Listeners\CheckAllRequiredArListener;
use App\Listeners\ESuccessLetterListener;
use App\Listeners\FinalApplicationProcessingListener;
use App\Listeners\MembershipAgreementLetterListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ApplicationSubmissionEvent::class => [
            ApplicationSubmissionListener::class,
        ],
        ArAddedEvent::class => [
            CheckAllRequiredArListener::class,
        ],
        MembershipAgreementLetterEvent::class => [
            MembershipAgreementLetterListener::class,
        ],
        ESuccessLetterEvent::class => [
            ESuccessLetterListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
