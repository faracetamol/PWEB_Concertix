<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        Ticket::create([
            'user_id' => 1,
            'event_id' => 1,
            'jumlah_tiket' => 2,
            'total_harga' => 300000,
        ]);

        Ticket::create([
            'user_id' => 2,
            'event_id' => 1,
            'jumlah_tiket' => 1,
            'total_harga' => 150000,
        ]);
    }
}
