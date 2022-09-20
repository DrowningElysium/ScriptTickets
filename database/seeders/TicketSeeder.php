<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketResponse;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = TicketCategory::all();
        $admin = User::where('is_admin', true)->first();
        $user = User::where('is_admin', false)->first();
        $newStatus = TicketStatus::where('title', 'New')->first();

        $ticket1 = Ticket::factory()
            ->hasAttached($categories->shuffle()->take(3), [], 'categories')
            ->has(TicketResponse::factory()->count(random_int(1, 5)), 'responses')
            ->create([
                'author_id' => $user->id, // user@example.com
                'status_id' => $newStatus->id, // new
            ]);
            
        $ticket1 = Ticket::factory()
            ->hasAttached($categories->shuffle()->take(3), [], 'categories')
            ->has(TicketResponse::factory()->count(random_int(1, 5)), 'responses')
            ->create([
                'author_id' => $user->id, // user@example.com
                'status_id' => $newStatus->id, // new
            ]);
    }
}
