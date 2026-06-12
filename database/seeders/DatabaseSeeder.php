<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $event = Event::first();

        if ($user && $event) {
            Ticket::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'jumlah_tiket' => 2,
                'total_harga' => 300000,
            ]);
        }
    }
}
