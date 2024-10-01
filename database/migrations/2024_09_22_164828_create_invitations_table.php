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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email');  // Email de l'invité
            $table->string('url');
            $table->foreignId('group_id')->constrained('groups');  // Groupe auquel il est invité
            $table->foreignId('invited_by')->constrained('users');  // Utilisateur qui a fait l'invitation
            $table->string('token')->nullable();  // Token unique pour l'invitation
            $table->boolean('is_registered')->default(0);  // Status d'inscription
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
