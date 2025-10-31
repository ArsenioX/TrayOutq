@extends('layouts.user')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg">
        <!-- Header -->
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">💬 Chat dengan Admin</h5>
        </div>

        <!-- Chat Box -->
        <div id="chatBox" class="card-body bg-light overflow-auto" style="height: 400px;">
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

                <div class="d-flex {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                    <div class="p-3 rounded shadow-sm {{ $msg->sender_id == auth()->id() ? 'bg-success text-white' : 'bg-secondary text-white' }}" style="max-width: 70%;">
                        <p class="mb-1 small">{{ $msg->message }}</p>
                        <small class="d-block text-white-50">{{ $timeLabel }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center mb-0">Belum ada pesan.</p>
            @endforelse
        </div>

        <!-- Input Form -->
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
