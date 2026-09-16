<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use Throwable;

class EticketImageService
{
    /**
     * Build a PNG e-ticket matching the stub + event panel layout.
     * Day pass (₦35k) stub = yellow; Full pass (₦80k) stub = orange.
     *
     * @return string Absolute path to the generated PNG
     */
    public function generate(Ticket $ticket): string
    {
        $width = 1200;
        $height = 520;
        $stubWidth = 400;

        $stubColor = $ticket->ticket_type === Ticket::TYPE_DAY_2
            ? 'f5c518' // yellow — Summit Day Pass
            : 'e85d04'; // orange — Full Summit Pass

        $manager = new ImageManager(new Driver());
        $image = $manager->create($width, $height)->fill('0c0a08');

        // Colored stub (left)
        $image->drawRectangle(0, 0, function ($rectangle) use ($stubWidth, $height, $stubColor) {
            $rectangle->size($stubWidth, $height);
            $rectangle->background($stubColor);
        });

        // Subtle checker overlay on stub
        for ($y = 0; $y < $height; $y += 24) {
            for ($x = 0; $x < $stubWidth; $x += 24) {
                if ((($x / 24) + ($y / 24)) % 2 === 0) {
                    $image->drawRectangle($x, $y, function ($rectangle) {
                        $rectangle->size(24, 24);
                        $rectangle->background('ffffff18');
                    });
                }
            }
        }

        // Perforation circles along the stub edge
        for ($y = 20; $y < $height; $y += 28) {
            $image->drawCircle($stubWidth, $y, function ($circle) {
                $circle->radius(8);
                $circle->background('0c0a08');
            });
        }

        $fontPath = $this->resolveFontPath();

        if ($ticket->ticket_type === Ticket::TYPE_FULL) {
            $this->drawText($image, 'FULL SUMMIT', (int) ($stubWidth / 2), 42, 26, 'ffffff', $fontPath, 'center');
            $this->drawText($image, 'PASS', (int) ($stubWidth / 2), 72, 26, 'ffffff', $fontPath, 'center');
        } else {
            $this->drawText($image, 'DAY PASS', (int) ($stubWidth / 2), 55, 28, 'ffffff', $fontPath, 'center');
        }

        // Admit box
        $image->drawRectangle(40, 100, function ($rectangle) {
            $rectangle->size(320, 44);
            $rectangle->border('ffffff', 2);
        });

        $admitName = mb_strimwidth($ticket->attendee_name, 0, 18, '…');
        $this->drawText($image, $admitName, 52, 128, 16, 'ffffff', $fontPath, 'left');
        $this->drawText($image, 'ID '.$ticket->code, 348, 128, 13, 'ffffff', $fontPath, 'right');

        // QR code
        $qrBinary = $this->fetchQrBinary($ticket->qrPayload(), 220);
        if ($qrBinary) {
            $qr = $manager->read($qrBinary);
            $qr->resize(220, 220);
            $image->place($qr, 'top-left', (int) (($stubWidth - 220) / 2), 170);
        }

        $this->drawText($image, 'Present at entrance', (int) ($stubWidth / 2), 480, 14, 'ffffff', $fontPath, 'center');

        // Right panel content
        $panelCenterX = (int) ($stubWidth + ($width - $stubWidth) / 2);

        $this->drawText($image, '21–22.10', $stubWidth + 70, 210, 26, 'ffffff', $fontPath, 'left');
        $image->drawLine(function ($line) use ($stubWidth) {
            $line->from($stubWidth + 70, 222);
            $line->to($stubWidth + 170, 222);
            $line->color('e85d04');
            $line->width(2);
        });
        $this->drawText($image, '2026', $stubWidth + 70, 250, 26, 'ffffff', $fontPath, 'left');

        $this->drawText($image, 'GBSAAC', $panelCenterX, 200, 48, 'ffffff', $fontPath, 'center');

        // Pass type badge
        $badgeLabel = $ticket->ticket_type === Ticket::TYPE_FULL ? 'FULL' : 'DAY 2';
        $image->drawRectangle($panelCenterX - 40, 220, function ($rectangle) {
            $rectangle->size(80, 28);
            $rectangle->background('e85d04');
        });
        $this->drawText($image, $badgeLabel, $panelCenterX, 240, 14, 'ffffff', $fontPath, 'center');

        $this->drawText($image, '2026', $panelCenterX, 290, 48, 'ffffff', $fontPath, 'center');

        $this->drawText($image, 'ALL DAY', $width - 90, 210, 22, 'ffffff', $fontPath, 'right');
        $image->drawLine(function ($line) use ($width) {
            $line->from($width - 170, 222);
            $line->to($width - 70, 222);
            $line->color('e85d04');
            $line->width(2);
        });
        $this->drawText($image, 'EVENT', $width - 90, 250, 22, 'ffffff', $fontPath, 'right');

        $this->drawText($image, 'CHASING THE WIND WHILE LOSING DAYLIGHT', $panelCenterX, 380, 16, 'ffffff', $fontPath, 'center');
        $this->drawText($image, '@ NEW CULTURE STUDIOS, IBADAN', $panelCenterX, 420, 16, 'ffffff', $fontPath, 'center');
        $this->drawText($image, $ticket->passName().' · '.$ticket->dayLabel(), $panelCenterX, 460, 14, 'f3ead8', $fontPath, 'center');

        $relative = 'tickets/'.$ticket->code.'.png';
        Storage::disk('local')->makeDirectory('tickets');
        $absolute = Storage::disk('local')->path($relative);
        $image->toPng()->save($absolute);

        return $absolute;
    }

    protected function drawText($image, string $text, int $x, int $y, int $size, string $color, ?string $fontPath, string $align): void
    {
        try {
            $image->text($text, $x, $y, function (FontFactory $font) use ($size, $color, $fontPath, $align) {
                if ($fontPath) {
                    $font->filename($fontPath);
                }
                $font->size($size);
                $font->color($color);
                $font->align($align);
                $font->valign('middle');
            });
        } catch (Throwable $e) {
            Log::warning('E-ticket text draw failed', [
                'text' => $text,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function fetchQrBinary(string $payload, int $size): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false])
                ->timeout(20)
                ->get('https://api.qrserver.com/v1/create-qr-code/', [
                    'size' => $size.'x'.$size,
                    'data' => $payload,
                    'margin' => 8,
                ]);

            if ($response->successful() && strlen($response->body()) > 200) {
                return $response->body();
            }

            Log::warning('QR fetch returned weak payload', [
                'status' => $response->status(),
                'len' => strlen($response->body()),
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to fetch QR for e-ticket', ['error' => $e->getMessage()]);
        }

        return null;
    }

    protected function resolveFontPath(): ?string
    {
        $candidates = [
            resource_path('fonts/DejaVuSans-Bold.ttf'),
            resource_path('fonts/DejaVuSans.ttf'),
            'C:/Windows/Fonts/arialbd.ttf',
            'C:/Windows/Fonts/arial.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/System/Library/Fonts/Supplemental/Arial Bold.ttf',
        ];

        foreach ($candidates as $path) {
            if (is_readable($path)) {
                return $path;
            }
        }

        return null;
    }
}
