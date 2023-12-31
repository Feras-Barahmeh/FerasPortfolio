<?php

use App\Enums\TypeSkill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('admin_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('type_skill', [TypeSkill::Soft->value, TypeSkill::Technical->value]);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills_admins');
    }
};
