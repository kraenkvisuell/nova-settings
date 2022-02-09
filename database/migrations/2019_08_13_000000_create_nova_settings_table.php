<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use OptimistDigital\NovaSettings\NovaSettings;

class CreateNovaSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Settings table
        Schema::create(NovaSettings::getSettingsTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->primary();
            $table->text('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(NovaSettings::getSettingsTableName());
    }
}
