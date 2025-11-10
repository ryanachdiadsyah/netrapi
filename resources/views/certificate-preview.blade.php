<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Certificate</title>
    <link href="https://fonts.cdnfonts.com/css/belarya-script" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/halleys" rel="stylesheet">
    <style>
        #certificate {
            position: relative;
            width: 1280px;
            height: 900px;
            background-size: cover;
            background-position: center;
            margin: 0 auto;
            border: 2px solid #ccc;
        }

        .name-text, .callsign-text {
            position: absolute;
            width: 100%;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            color: #000;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container text-center mt-4">
        <div id="certificate"
            style="background-image: url('{{ asset($event->certificate_background) }}')">
            @php
                $design         = json_decode($event->certificate_design_options, true);
                $namePos        = $design['name_position'] ?? ['x' => 640, 'y' => 455];
                $callPos        = $design['callsign_position'] ?? ['x' => 640, 'y' => 375];
                $nameFontSize   = $design['name_font_size'] ?? 36;
                $callFontSize   = $design['callsign_font_size'] ?? 72;
                $nameFontType   = $design['name_font_type'] ?? 'Halleys';
                $callFontType   = $design['callsign_font_type'] ?? 'Poppins';
            @endphp
            
            <div class="name-text" 
                style="top: {{ $namePos['y'] }}px; left: 0; font-size: {{ $nameFontSize }}px; font-family: '{{ $nameFontType }}', sans-serif;">
                {{ $owner }}
            </div>
            <div class="callsign-text" 
                style="top: {{ $callPos['y'] }}px; left: 0; font-size: {{ $callFontSize }}px; font-family: '{{ $callFontType }}', sans-serif;">
                {{ $callsign }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
    window.onload = async () => {
        const cert = document.getElementById('certificate');

        // Tunggu sebentar supaya semua gambar & font ter-load sempurna
        await new Promise(resolve => setTimeout(resolve, 800));

        const canvas = await html2canvas(cert, {
            scale: 2,            // biar hasilnya tajam
            useCORS: true        // izinkan cross-domain image
        });

        const imageData = canvas.toDataURL('image/jpeg', 0.95);
        const link = document.createElement('a');
        link.download = '{{ $callsign }}_{{ $event->event_slug }}.jpg';
        link.href = imageData;

        // Auto trigger download
        link.click();

        // Optional: redirect setelah download (misal balik ke halaman event)
        // window.location.href = "{{ route('event.details', $event->event_slug) }}";
    };
    </script>
</body>
</html>
