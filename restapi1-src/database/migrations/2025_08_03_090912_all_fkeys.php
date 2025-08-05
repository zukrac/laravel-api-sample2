<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Company hasOne address
        Schema::table('companies', function (Blueprint $table) {
            $table->bigInteger('address_id')->nullable()->unsigned();

            $table->foreign('address_id', 'companies_address_id_foreign')
                ->references('id')
                ->on('addresses')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
//        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_address_id_foreign');
            $table->dropColumn('address_id');
        });
//        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
};
