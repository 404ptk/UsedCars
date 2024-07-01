<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Car;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('name', 50)->nullable();
            $table->string('engine', 10)->nullable();
            $table->integer('capacity')->nullable();
            $table->string('brand', 25)->nullable();
            $table->string('localization', 70)->nullable();
            $table->string('vin', 17)->unique()->nullable();
            $table->string('gearbox')->nullable();
            $table->string('condition')->nullable();
            $table->string('color')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->string('drive')->nullable();    
            $table->string('body')->nullable();    
            $table->integer('mileage')->nullable();
            $table->integer('hp')->nullable();
            $table->integer('price')->nullable();
            $table->date('production_date')->nullable();
            $table->date('first_registration')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();  // Dodaj to pole
            $table->foreign('owner_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('image');  // Usuń to pole w razie rollback
            $table->dropSoftDeletes();
        });
    }
};