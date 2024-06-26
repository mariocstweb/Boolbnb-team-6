<?php

use App\Models\Apartment;
use App\Models\Service;
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

        /* TABELLA PONTE CON GLI ID DEGLI APPARTEMENTI E SERVIZI */
        Schema::create('apartment_service', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Apartment::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Service::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        /* BUTTI GIU' LA TABELLA */
        Schema::dropIfExists('apartment_service');
    }
};