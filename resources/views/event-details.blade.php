@extends('_layouts.homepage.index')

@push('style')
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $event->event_name }}</h2>
                    Created By : {{ $event->organizer_name }} | {{ $event->organizer_callsign }}
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="lead">Event Detail</p>
                            <table class="table table-bordered table-striped w-100">
                                <tr>
                                    <td>Event Name</td>
                                    <td>:</td>
                                    <td>{{ $event->event_name }}</td>
                                </tr>
                                <tr>
                                    <td>Event Date</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($event->event_from_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($event->event_to_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td>:</td>
                                    <td>{{ $event->event_location }}</td>
                                </tr>
                                <tr>
                                    <td>Bands</td>
                                    <td>:</td>
                                    <td>
                                        @php
                                            $bands = json_decode($event->band);
                                        @endphp
                                        @foreach ($bands as $band)
                                            <span class="badge border border-primary border-1 text-primary">{{ $band }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Modes</td>
                                    <td>:</td>
                                    <td>
                                        @php
                                            $modes = json_decode($event->mode);
                                        @endphp
                                        @foreach ($modes as $mode)
                                            <span class="badge border border-danger border-1 text-danger">{{ strtoupper($mode) }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Organizer</td>
                                    <td>:</td>
                                    <td>{{ $event->organizer_name }} | {{ $event->organizer_callsign }}</td>
                                </tr>
                                <tr>
                                    <td>Organizer Email</td>
                                    <td>:</td>
                                    <td>{{ $event->organizer_email }}</td>
                                </tr>
                                <tr>
                                    <td>Organizer Phone</td>
                                    <td>:</td>
                                    <td>{{ $event->organizer_phone }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <p class="lead">Event Photo</p>
                            <div class="row g-2">
                                @for($i = 1; $i <= 9; $i++)
                                <div class="col-4">
                                    <img src="{{ asset('assets/event-photo/rapi (' . $i . ').jpeg') }}"
                                        alt="Event Photo"
                                        class="img-fluid rounded clickable-photo"
                                        style="cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#photoModal"
                                        data-photo="{{ asset('assets/event-photo/rapi (' . $i . ').jpeg') }}">
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Logged Station</h5>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Callsign</th>
                                    <th>Frequency</th>
                                    <th>RST S-R</th>
                                    <th>Band & Mode</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $logs = App\Models\Qsolist::where('event_id', $event->id)->get();
                                @endphp
                                @forelse ($logs as $index => $log)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $log->callsign }}</td>
                                    <td>{{ $log->frequency }}</td>
                                    <td>{{ $log->rst_sent }} - {{ $log->rst_received }}</td>
                                    <td>{!! '<span class="badge border border-primary border-1 text-primary">'.$log->band.'</span>' !!} {!! '<span class="badge border border-danger border-1 text-danger">'.strtoupper($log->mode).'</span>' !!}</td>
                                    <td>
                                        <a href="{{ route('event.download', ['id' => $event->id, 'callsign' => $log->callsign]) }}" class="btn btn-sm btn-primary">Download Sertifikat</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No logs available.</td>
                                </tr>
                                @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center p-0">
                <img src="" id="photoModalImage" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const datatable = new simpleDatatables.DataTable('.datatable');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalImage = document.getElementById('photoModalImage');
            document.querySelectorAll('.clickable-photo').forEach(img => {
                img.addEventListener('click', () => {
                    modalImage.src = img.dataset.photo;
                });
            });
        });
    </script>
@endpush