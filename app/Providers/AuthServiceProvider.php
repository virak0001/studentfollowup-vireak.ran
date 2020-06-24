<?php

namespace App\Providers;
use App\User;
use App\Comment;
use App\Policies\CommentPolicy;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Student;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Student::class => StudentPolicy::class,
        Comment::class => CommentPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::resource('student','App\Policies\StudentPolicy');
        Gate::resource('comment','App\Policies\CommentPolicy');
    }
}
