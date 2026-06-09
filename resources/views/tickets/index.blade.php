<h1>Tiket Saya</h1>
@foreach($tickets as $ticket)

<div style="border:1px solid #ccc;padding:10px;margin:10px">

    <h3>{{ $ticket->event->nama }}</h3>
    <p>Jumlah Tiket: {{ $ticket->jumlah_tiket }}</p>
    <p>Total Harga: Rp {{ number_format($ticket->total_harga) }}</p>

    <form method="POST"
          action="{{ route('tickets.destroy', $ticket->id) }}">
        @csrf
        @method('DELETE')

        <button type="submit">
            Batalkan Tiket
        </button>
    </form>

</div>
@endforeach
