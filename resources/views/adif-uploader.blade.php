<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIF Uploader</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>ADIF Uploader</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('uploader-adif.handle') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="event_id">Select Event:</label>
            <select name="event_id" id="event_id" required>
                <option value="" disabled selected>Select an event</option>
                @php
                    $events = App\Models\EventList::where('is_published', true)->get();
                @endphp
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="adif_file">Select ADIF File:</label>
            <input type="file" name="adif_file" id="adif_file" accept=".adi,.adif" required>
        </div>
        <div>
            <button type="submit">Upload</button>
        </div>
    </form>
</body>
</html>