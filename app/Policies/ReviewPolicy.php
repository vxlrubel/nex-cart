<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Review $review): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('review.view');
    }

    public function update(User $user, Review $review): bool
    {
        return $review->user_id === $user->id || $user->hasPermission('review.manage');
    }

    public function delete(User $user, Review $review): bool
    {
        return $review->user_id === $user->id || $user->hasPermission('review.manage');
    }

    public function manage(User $user): bool
    {
        return $user->hasPermission('review.manage');
    }
}
