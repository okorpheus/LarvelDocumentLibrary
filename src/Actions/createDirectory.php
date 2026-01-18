<?php

namespace Okorpheus\DocumentLibrary\Actions;

use Okorpheus\DocumentLibrary\Enums\VisibilityValues;
use Okorpheus\DocumentLibrary\Models\Directory;

class CreateDirectory
{
    public function __invoke(
        string $name,
        ?string $description,
        VisibilityValues $visibility,
        ?int $parentId = null,
        ?int $userId = null,
    ): Directory {
        return Directory::create([
            'name' => $name,
            'description' => $description,
            'parent_id' => $parentId,
            'sort_order' => 1,
            'user_id' => $userId ?? auth()->id(),
            'visibility' => $visibility,
        ]);
    }
}
