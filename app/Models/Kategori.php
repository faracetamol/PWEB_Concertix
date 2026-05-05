<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Kategori extends Model
{
    public function events()
{
    return $this->belongsToMany(Event::class, 'event_kategori');
}
}
