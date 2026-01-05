<?php

namespace Okorpheus\DocumentLibrary\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Okorpheus\DocumentLibrary\Enums\VisibilityValues;

class Document extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort_order',
        'visibility',
        'disk',
        'disk_path',
        'parent_id',
        'size',
        'mime_type',
        'user_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function (Document $document) {
            if ($document->disk && $document->disk_path) {
                Storage::disk($document->disk)->delete($document->disk_path);
            }
        });
    }

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function readableSize(): string
    {
        $bytes = $this->size;

        if ($bytes === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        $size = $bytes / pow(1024, $power);

        return round($size, 2) . ' ' . $units[$power];
    }

    public function downloadUrl(): string
    {
        return Storage::disk($this->disk)->url($this->disk_path);
    }
}
