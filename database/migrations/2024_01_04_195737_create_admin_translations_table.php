<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            /**
             * translations settings
             */
            $table->string('locale')->index();
            $table->unique(['admin_id','locale']);
            $table->foreignId('admin_id')
                ->constrained()
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_translations');
    }
};
