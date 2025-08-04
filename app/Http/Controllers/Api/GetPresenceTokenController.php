<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Settings\PresenceSetting;
use Milon\Barcode\Facades\DNS2DFacade;

class GetPresenceTokenController extends Controller
{
    public function __invoke()
    {
        $token = app(PresenceSetting::class)->token;

        if (empty($token)) {
            return response()->json();
        }

        return DNS2DFacade::getBarcodeHTML($token, 'QRCODE');
    }
}
