@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        {{-- Sidebar User List --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    {{-- DITERJEMAHKAN --}}
                    <h5 class="mb-0">{{ __('User') }}</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($users as $u)
                        <li class="list-group-item">
                            <a href="{{ route('user.chat', ['user_id' => $u->id]) }}" 
                               class="text-decoration-none d-block">
                                {{ $u->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Chat Box --}}
        <div class="col-md-9">
            <div class="card shadow-sm">
                @if ($selectedUser)
                    <div class="card-header bg-success text-white">
                        {{-- DITERJEMAHKAN --}}
                        <h5 class="mb-0">{{ __('Chat dengan') }} {{ $selectedUser->name }}</h5>
                    </div>

                    <div class="card-body" style="height: 450px; overflow-y: auto;">
                        @forelse ($messages as $msg)
                            @php
                                $date = $msg->created_at->timezone('Asia/Jakarta');
                                if ($date->isToday()) {
                                    // DITERJEMAHKAN (Kunci sudah ada)
                                    $timeLabel = __('Hari ini') . ' ' . $date->format('H:i');
                                } elseif ($date->isYesterday()) {
                                    // DITERJEMAHKAN (Kunci sudah ada)
                                    $timeLabel = __('Kemarin') . ' ' . $date->format('H:i');
                                } else {
                                    $timeLabel = $date->format('d M Y H:i');
                                }
                            @endphp

                            <div class="d-flex {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                                <div class="p-2 rounded {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light border' }}" style="max-width: 70%;">
                                    <p class="mb-1">{{ $msg->message }}</p>
                                    <small class="text-muted">{{ $timeLabel }}</small>
                                </div>
                            </div>
                        @empty
                            {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                            <p class="text-muted text-center">{{ __('Belum ada pesan.') }}</p>
                        @endforelse
                    </div>

                    <div class="card-footer">
                        <form action="{{ route('user.chat.store') }}" method="POST" class="d-flex">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                            {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                            <input type="text" name="message" class="form-control me-2" placeholder="{{ __('Ketik pesan...') }}">
                            {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                            <button type="submit" class="btn btn-success">{{ __('Kirim') }}</button>
                        </form>
                    </div>
                @else
                    <div class="card-body text-center text-muted">
                        {{-- DITERJEMAHKAN --}}
                        {{ __('Pilih user untuk memulai percakapan.') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection