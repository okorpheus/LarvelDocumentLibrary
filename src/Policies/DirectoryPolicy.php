<?php

namespace Okorpheus\DocumentLibrary\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Okorpheus\DocumentLibrary\Enums\VisibilityValues;
use Okorpheus\DocumentLibrary\Models\Directory;

class DirectoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Directory $directory): bool
    {
        // Public directories
        if ($directory->visibility === VisibilityValues::PUBLIC) {
            return true;
        }

        // All other directories require a logged in user
        if (!$user) {
            return false;
        }

        // Restricted directories - any authenticated user can view
        if ($directory->visibility === VisibilityValues::RESTRICTED) {
            return true;
        }

        // Admins can see it
        if ($this->isAdmin($user)) {
            return true;
        }

        // Owner can see it
        return $directory->user_id === $user->id;
    }

    public function create(User $user, ?Directory $parentDirectory = null): bool
    {
        // If no parent directory (root level), allow
        if (!$parentDirectory) {
            return true;
        }

        // Admins can create anywhere
        if ($this->isAdmin($user)) {
            return true;
        }

        // Public directories - anyone can create subdirectories
        if ($parentDirectory->visibility === VisibilityValues::PUBLIC) {
            return true;
        }

        // Otherwise, must own the parent directory
        return $parentDirectory->user_id === $user->id;
    }

    public function update(User $user, Directory $directory): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $directory->user_id === $user->id;
    }

    public function delete(User $user, Directory $directory): bool
    {
        // Cannot delete a directory that isn't empty
        if (! $directory->checkIfEmpty()) {
            return false;
        }

        if ($this->isAdmin($user)) {
            return true;
        }

        return $directory->user_id === $user->id;
    }

    protected function isAdmin(User $user): bool
    {
        $adminCheck = config('document-library.admin_check');

        if (is_callable($adminCheck)) {
            return $adminCheck($user);
        }

        return method_exists($user, 'isAdmin') ? $user->isAdmin() : false;
    }
}
