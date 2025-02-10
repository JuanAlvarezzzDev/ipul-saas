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
        Schema::create('transaction_concepts', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable(false);
            $table->text("description")->nullable();
            $table->boolean("active")->default(true);
            $table->unsignedBigInteger('workspace_id');
            $table->string('transaction_type');
            $table->timestamps();
            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_concepts');
    }
};
