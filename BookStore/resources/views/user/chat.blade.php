@extends('layouts.user')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Chat dengan Admin</h5>
        </div>

        <div class="card-body p-3" id="chatBox" style="height: 400px; overflow-y: auto;">
            @forelse ($messages as $msg)
                @php
                    $date = $msg->created_at->timezone('Asia/Jakarta');
                    if ($date->isToday()) {
                        $timeLabel = 'Hari ini ' . $date->format('H:i');
                    } elseif ($date->isYesterday()) {
                        $timeLabel = 'Kemarin ' . $date->format('H:i');
                    } else {
                        $timeLabel = $date->format('d M Y H:i');
                    }
                @endphp

                <div class="d-flex mb-2 {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-2 rounded shadow-sm 
                        {{ $msg->sender_id == auth()->id() ? 'bg-success text-white' : 'bg-light text-dark' }}"
                        style="max-width: 70%;">
                        <p class="mb-1 small">{{ $msg->message }}</p>
                        <small class="text-muted">{{ $timeLabel }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada pesan.</p>
            @endforelse
        </div>

        <div class="card-footer bg-white">
            <form action="{{ route('user.chat.store') }}" method="POST" class="d-flex gap-2">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ \App\Models\User::where('role', 'admin')->first()->id }}">
                <input type="text" name="message" class="form-control" placeholder="Ketik pesan..." required>
                <button type="submit" class="btn btn-success">Kirim</button>
            </form>
        </div>
    </div>
</div>

{{-- Auto Scroll --}}
<script>
    const chatBox = document.getElementById('chatBox');
    if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>
@endsection
