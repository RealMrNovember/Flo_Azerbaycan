<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class CategoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Category $category): bool
    {
        return true;
    }

    public function delete(User $user, Category $category): bool
    {
        return true;
    }

    public function restore(User $user, Category $category): bool
    {
        return true;
    }

    public function forceDelete(User $user, Category $category): bool
    {
        return true;
    }
}
