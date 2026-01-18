<?php

namespace Okorpheus\DocumentLibrary\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Okorpheus\DocumentLibrary\Enums\VisibilityValues;
use Okorpheus\DocumentLibrary\Models\Directory;
use Okorpheus\DocumentLibrary\Models\Document;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true; // Public can see the index
    }

    public function view(?User $user, Document $document): bool
    {
        // Public Documents
        if ($document->visibility === VisibilityValues::PUBLIC) {
            return true;
        }

        // All other documents require a logged in user
        if (!$user) {
            return false;
        }

        // Restricted documents - any authenticated user can view
        if ($document->visibility === VisibilityValues::RESTRICTED) {
            return true;
        }

        // Admins can see it
        if ($this->isAdmin($user)) {
            return true;
        }

        // Owner can see it
        return $document->user_id === $user->id;
    }

    public function create(User $user, ?Directory $directory = null): bool
    {
        // If no directory specified (root level), allow
        if (!$directory) {
            return true;
        }

        // Admins can create anywhere
        if ($this->isAdmin($user)) {
            return true;
        }

        // Public directories - anyone can create
        if ($directory->visibility === VisibilityValues::PUBLIC) {
            return true;
        }

        // Otherwise, must own the directory
        return $directory->user_id === $user->id;
    }

    public function update(User $user, Document $document): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($document->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Document $document): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($document->user_id === $user->id) {
            return true;
        }

        return false;
    }

    protected function isAdmin(User $user): bool
    {
        // Function defined in config
        $adminCheck = config('document-library.admin_check');

        if (is_callable($adminCheck)) {
            return $adminCheck($user);
        }

        // Default fallback
        return method_exists($user, 'isAdmin') ? $user->isAdmin() : false;
    }
}
