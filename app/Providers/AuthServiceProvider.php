<?php

namespace App\Providers;

use App\Models\Registration;
use App\Models\RegistrationBatch;
use App\Models\SelectionSchedule;
use App\Models\User;
use App\Policies\RegistrationBatchPolicy;
use App\Policies\RegistrationPolicy;
use App\Policies\SelectionSchedulePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Registration::class => RegistrationPolicy::class,
        RegistrationBatch::class => RegistrationBatchPolicy::class,
        SelectionSchedule::class => SelectionSchedulePolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
