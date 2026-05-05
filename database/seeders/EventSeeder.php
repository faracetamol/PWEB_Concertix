<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'nama' => 'Rock Nation',
            'lokasi' => 'Surabaya',
            'tanggal' => '2026-07-20',
            'stok' => 300,
            'harga' => 400000,
            'gambar' => 'rock.png'
        ]);

        Event::create([
            'nama' => 'Indie Night',
            'lokasi' => 'Bandung',
            'tanggal' => '2026-07-15',
            'stok' => 200,
            'harga' => 300000,
            'gambar' => 'indie.png'
        ]);

        Event::create([
            'nama' => 'Jazz Festival',
            'lokasi' => 'Jakarta',
            'tanggal' => '2026-08-10',
            'stok' => 250,
            'harga' => 350000,
            'gambar' => 'jazz.png'
        ]);
    }
}
