<?php

namespace App\Http\Controllers;

use App\Models\EventList;
use App\Models\QsoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class EventHomepageController extends Controller
{
    public function allEvent()
    {
        return view('event-list');
    }

    public function eventDetails($slug)
    {
        if(!$slug){
            abort(404);
        } else {
            $findedEvent = EventList::where([
                'event_slug' => $slug,
                'is_published' => true,
            ])->first();
            if (!$findedEvent) {
                abort(404);
            }
            return view('event-details', ['event' => $findedEvent]);
        }
    }

    public function certificatePreview($id, $callsign)
    {
        $event = EventList::where('id', $id)
            ->where('is_published', true)
            ->firstOrFail();

        // Check Callsign is in QSO or NOT
        $check = QsoList::where([
            'event_id'  => $id,
            'callsign'  => $callsign,
        ])->first();

        if($check){
            $sdppi = $this->getNameFromSDPPI($callsign);
            return view('certificate-preview', [
                'event' => $event,
                'callsign' => strtoupper($callsign),
                'owner' => $sdppi['name'] ?? '-'
            ]);
        }
        return redirect()->route('event.details', ['slug' => $event->event_slug])->with([
            'status'    => 'error',
            'message'   => 'Data tidak di temukan'
        ]);

    }

    protected function getNameFromSDPPI($callsign)
    {
        $callsign = strtoupper(trim($callsign));
        $cacheKey = 'sdppi_callsign_' . $callsign;

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addHours(12), function () use ($callsign) {
            try {
                $url = "https://iar-ikrap.postel.go.id/registrant/searchDataIar/?callsign=" . $callsign;

                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36',
                    'Accept' => '*/*',
                    'Accept-Language' => 'en-US,en;q=0.9,id;q=0.8',
                    'Referer' => 'https://iar-ikrap.postel.go.id/',
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Cookie' => 'PHPSESSID=3m6rd5uukrhj2pbq60aosg8rd4; _toffisuid=coZFQmKG/VRhP9C2AwnXAg==; _toffuuid=coZFQmKG/VRhP9C2AwnXAg=='
                ])
                ->timeout(10)
                ->get($url);

                if (!$response->successful()) {
                    throw new \Exception("SDPPI status: {$response->status()}");
                }

                $json = $response->json();
                $html = is_string($json) ? $json : json_encode($json);

                libxml_use_internal_errors(true);
                $dom = new \DOMDocument();
                $dom->loadHTML($html);
                libxml_clear_errors();

                $xpath = new \DOMXPath($dom);
                $metaDetails = $xpath->query("//div[@class='meta-details']");
                $metaTitles  = $xpath->query("//div[@class='title-meta']");

                $data = [];
                for ($i = 0; $i < $metaTitles->length; $i++) {
                    $label = trim($metaTitles->item($i)->textContent);
                    $value = trim($metaDetails->item($i)->textContent ?? '');
                    $data[$label] = $value;
                }

                return [
                    'name'     => $data['Nama Pemilik (Full name) :'] ?? '-',
                    'province' => $data['Provinsi (Province) :'] ?? '-',
                    'callsign' => $data['Tanda Panggilan (Callsign) :'] ?? $callsign,
                    'status'   => $data['Status :'] ?? '-',
                    'validity' => $data['Masa Laku (Date of expiration) :'] ?? '-',
                    'from_cache' => false,
                    'cached_at' => now()->toDateTimeString(),
                ];

            } catch (\Exception $e) {
                return [
                    'name' => 'UNKNOWN',
                    'province' => null,
                    'callsign' => $callsign,
                    'status' => null,
                    'validity' => null,
                    'from_cache' => false,
                    'cached_at' => now()->toDateTimeString(),
                ];
            }
        });
    }
}
