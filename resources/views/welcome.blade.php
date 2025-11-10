@extends('_layouts.homepage.index')

@section('content')

<div class="container">
    <h2>Selamat Datang</h2>
    <p>Kemudahan berbagi sertifikat RAPI dalam satu platform.</p>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card bg-transparent border-0">
                <div class="card-header">
                    <h5>Event Berlangsung</h5>
                </div>
                <div class="card-body p-2 d-flex flex-column gap-2">
                    @php
                        $events = App\Models\EventList::where('event_from_date', '<=', now())
                        ->where('event_to_date', '>=', now())
                        ->where('is_published', true)
                        ->take(5)
                        ->get();
                    @endphp
                    @forelse ($events as $item)
                    <a href="{{ route('event.details', $item->event_slug) }}">
                        <div class="row g-0 border border-2 rounded overflow-hidden bg-light">
                            <div class="col-md-3">
                                <img src="{{ $item->event_thumbnail !== NULL ? Storage::url($item->event_thumbnail) : asset('assets/img/blank-card.jpg') }}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title px-0 py-2">{{ $item->event_name }}</h5>
                                    <p class="card-text">{{ \Carbon\Carbon::parse($item->event_from_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($item->event_to_date)->format('d M Y') }} </p>
                                    @php
                                        $bands = json_decode($item->band);
                                        $modes = json_decode($item->mode);
                                    @endphp
                                    @foreach ($bands as $band)
                                        <span class="badge border border-primary border-1 text-primary">{{ $band }}</span>
                                    @endforeach
                                    @foreach ($modes as $mode)
                                        <span class="badge border border-danger border-1 text-danger">{{ $mode }}</span>
                                    @endforeach
                                    <span class="badge border border-warning border-1 text-warning">{{ $item->event_location }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                        <p class="text-center">Tidak ada event yang sedang berlangsung.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Event Yang Akan Datang</h5>
                </div>
                <div class="card-body p-2 d-flex flex-column gap-2">
                    @php
                        $events = App\Models\EventList::where('event_from_date', '>', now())
                        ->where('is_published', true)
                        ->take(5)
                        ->get();
                    @endphp
                    @forelse ($events as $item)
                    <a href="{{ route('event.details', $item->event_slug) }}">
                        <div class="row g-0 border border-2 rounded overflow-hidden bg-light">
                            <div class="col-md-3">
                                <img src="{{ $item->event_thumbnail !== NULL ? Storage::url($item->event_thumbnail) : asset('assets/img/blank-card.jpg') }}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title px-0 py-2">{{ $item->event_name }}</h5>
                                    <p class="card-text">{{ \Carbon\Carbon::parse($item->event_from_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($item->event_to_date)->format('d M Y') }} </p>
                                    @php
                                        $bands = json_decode($item->band);
                                        $modes = json_decode($item->mode);
                                    @endphp
                                    @foreach ($bands as $band)
                                        <span class="badge border border-primary border-1 text-primary">{{ $band }}</span>
                                    @endforeach
                                    @foreach ($modes as $mode)
                                        <span class="badge border border-danger border-1 text-danger">{{ $mode }}</span>
                                    @endforeach
                                    <span class="badge border border-warning border-1 text-warning">{{ $item->event_location }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                        <p class="text-center">Tidak ada event yang akan datang.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="text-center">
                <a href="{{ route('event') }}">Lihat Semua Event</a>
            </div>
        </div>
    </div>
</div>
@endsection