<?php

namespace Okorpheus\DocumentLibrary\Models;

use Illuminate\Database\Eloquent\Model;
use Okorpheus\DocumentLibrary\Enums\VisibilityValues;

class Document extends Model
{
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'visibility' => VisibilityValues::class,
        ];
    }

    public function getTable(): string
    {
        return \config('documentlibrary.db_table_prefix').'documents';
    }
}
