<?php

namespace Okorpheus\DocumentLibrary\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Directory extends Model
{
    protected $table;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getTable(): string
    {
        return \config('documentlibrary.db_table_prefix').'directories';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
