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
        Schema::create('phones', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('number')->nullable(); // VARCHAR(255) NULL
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('set null')
                ->onUpdate('no action');

            $table->timestamps(); // Add created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
