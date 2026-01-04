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
        $this->tablename = \config('documentlibrary.db_table_prefix').'directories';
    }

    public function up(): void
    {
        Schema::create($this->tablename, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignIdFor(Directory::class, 'parent_id')->nullable()->constrained($this->tablename)->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->string('visibility');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tablename);
    }
};
