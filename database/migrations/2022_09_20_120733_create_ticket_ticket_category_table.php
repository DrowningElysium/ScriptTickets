<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('ticket_ticket_category', static function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Ticket::class, 'ticket_id');
            $table->foreignIdFor(\App\Models\TicketCategory::class, 'category_id');

            $table->primary(['ticket_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_ticket_category');
    }
};
