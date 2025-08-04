<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->string('start_token')->nullable();
            $table->string('end_token')->nullable();
            $table->string('status');
            $table->string('reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
