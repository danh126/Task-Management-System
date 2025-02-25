<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('task-created', function ($user) {
    return in_array($user->role, ['manager','employee']);
});

Broadcast::channel('task-updated', function ($user) {
    return in_array($user->role, ['manager','employee']);
});

// Cho phép manager và employee truy cập vào channel
Broadcast::channel('task-status-update', function ($user) {
    return in_array($user->role, ['manager','employee']);
});

Broadcast::channel('task-delete', function ($user) {
    return in_array($user->role, ['manager','employee']);
});

Broadcast::channel('create-task-attachment', function ($user) {
    return in_array($user->role, ['manager','employee']);
});

Broadcast::channel('delete-task-attachment', function ($user) {
    return in_array($user->role, ['manager','employee']);
});

Broadcast::channel('updated-task-attachment', function ($user) {
    return in_array($user->role, ['manager','employee']);
});