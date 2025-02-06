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
            $table->unsignedBigInteger('transaction_type_id');
            $table->timestamps();
            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('cascade');
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
