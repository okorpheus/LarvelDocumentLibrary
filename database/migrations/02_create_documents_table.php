<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Okorpheus\DocumentLibrary\Models\Directory;

return new class extends Migration {

    protected string $tablename;

    public function __construct()
    {
        $this->tablename = \config('documentlibrary.db_table_prefix').'documents';
    }

    public function up(): void
    {
        Schema::create($this->tablename, function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name shown to users. Original upload name by default
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('visibility');
            $table->string('disk');
            $table->string('disk_path')->unique();
            $table->foreignIdFor(Directory::class, 'parent_id')->nullable()->constrained(\config('documentlibrary.db_table_prefix').'directories')->cascadeOnDelete();
            $table->unsignedInteger('size'); //bytes
            $table->string('mime_type')->default('application/pdf');
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tablename);
    }
};
