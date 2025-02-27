<?php

namespace App\Providers;

use App\Interface\ProjectRepositoryInterface;
use App\Interface\TaskAttachmentsInterface;
use App\Interface\TaskCommentInterface;
use App\Interface\TaskRepositoryInterface;
use App\Interface\UserRepositoryInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskAttachmentRepository;
use App\Repositories\TaskCommentRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TaskAttachmentsInterface::class, TaskAttachmentRepository::class);
        $this->app->bind(TaskCommentInterface::class, TaskCommentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
