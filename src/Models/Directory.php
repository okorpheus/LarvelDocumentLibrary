<?php

namespace Okorpheus\DocumentLibrary\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Okorpheus\DocumentLibrary\Enums\VisibilityValues;

class Directory extends Model
{
    protected $table;

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
        return \config('documentlibrary.db_table_prefix').'directories';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Directory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Directory::class, 'parent_id');
    }

    public function fullPath(): string
    {
        $path = '/'.$this->name;
        if (! $this->parent) {
            return $path;
        }
        $path = '/'.$this->parent->name.$path;
        return $path;

    }
}
