<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('model_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Kullanıcı ID
            $table->string('model_type'); // Model türü (ör. App\Models\Hospital)
            $table->unsignedBigInteger('model_id'); // Model ID (ör. hospital_id)
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade'); // İzin ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_permissions');
    }
};
