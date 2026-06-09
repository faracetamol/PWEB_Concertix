<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('event')
            ->where('user_id', auth()->id())
            ->get();

        return view('tickets.index', compact('tickets'));
    }

   public function store(Request $request)
{
    $event = Event::findOrFail($request->event_id);

    $ticket = Ticket::create([
    'user_id' => auth()->id(),
    'event_id' => $event->id,
    'jumlah_tiket' => $request->jumlah_tiket,
    'total_harga' => $event->harga * $request->jumlah_tiket,
    'status_pembayaran' => 'Belum Lunas',
]);
return redirect('/pembayaran/' . $ticket->id);}

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return back()->with('success', 'Tiket berhasil dibatalkan');
    }
}
