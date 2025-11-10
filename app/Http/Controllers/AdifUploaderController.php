<?php

namespace App\Http\Controllers;

use App\Models\QsoList;
use Illuminate\Http\Request;
use Storage;

class AdifUploaderController extends Controller
{
    public function index()
    {
        return view('adif-uploader');
    }

    /**
     * Proses upload file ADIF.
     */
    public function upload(Request $request)
    {
        
        try {
            $request->validate([
                'adif_file' => 'required|file|max:20480', // 20MB
                'event_id' => 'required|exists:event_lists,id',
            ]);
            // Simpan file
            // dd('here');
            $file = $request->file('adif_file');
            $path = $file->store('adif_uploads');

            // Catat di tabel adif_uploads
            // $upload = AdifUpload::create([
            //     'user_id' => $request->user()->id ?? null,
            //     'filename' => $path,
            //     'original_name' => $file->getClientOriginalName(),
            //     'status' => 'processing',
            // ]);

            // Baca isi file
            $content = Storage::get($path);

            // Parse isi ADIF
            $records = $this->parseAdif($content);
            $inserted = 0;

            // Simpan ke tabel QSO
            foreach ($records as $r) {
                QsoList::firstOrCreate([
                    'event_id' => $request->event_id ?? null,
                    'callsign' => $r['call'] ?? null,
                    'qso_date' => $r['qso_date'] ?? null,
                    'frequency' => $r['freq'] ?? null,
                    'band' => $r['band'] ?? null,
                    'mode' => $r['mode'] ?? null,
                    'rst_sent' => $r['rst_sent'] ?? null,
                    'rst_received' => $r['rst_rcvd'] ?? null,
                    'operator_callsign' => $r['operator'] ?? null,
                    'uploaded_by' => '1',
                ]);
                $inserted++;
            }
            return redirect()->back()->with('success', "File ADIF berhasil diunggah. Total QSO disimpan: $inserted.");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses file ADIF: ' . $th->getMessage());
        }
        
    }

    /**
     * Parser sederhana untuk file ADIF.
     * Mengembalikan array associative per record.
     */
    private function parseAdif(string $content): array
    {
        $records = [];
        $content = preg_replace("/\r\n|\r|\n/", " ", $content);
        $parts = preg_split("/<eor>/i", $content);

        foreach ($parts as $part) {
            if (trim($part) === '') continue;

            $record = [];
            preg_match_all("/<([^:>]+)(?::(\d+))?>([^<]*)/i", $part, $matches, PREG_SET_ORDER);

            foreach ($matches as $m) {
                $field = strtolower(trim($m[1]));
                $value = trim($m[3]);
                if ($value !== '') {
                    $record[$field] = $value;
                }
            }

            // Format tanggal ADIF YYYYMMDD → YYYY-MM-DD
            if (!empty($record['qso_date']) && preg_match('/^\d{8}$/', $record['qso_date'])) {
                $record['qso_date'] = substr($record['qso_date'], 0, 4) . '-' .
                                      substr($record['qso_date'], 4, 2) . '-' .
                                      substr($record['qso_date'], 6, 2);
            }

            $records[] = $record;
        }

        return $records;
    }
}
