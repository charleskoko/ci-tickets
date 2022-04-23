<?php

use App\Models\EventTicketTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_ticket_templates', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->float('price')->nullable();
            $table->foreign('event_id')->references('id')->on('events');
            $table->bigInteger('event_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_ticket_templates');
    }
};
