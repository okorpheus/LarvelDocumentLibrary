<?php

namespace Okorpheus\DocumentLibrary\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getTable(): string
    {
        return \config('documentlibrary.db_table_prefix').'documents';
    }
}
