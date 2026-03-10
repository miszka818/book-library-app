<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\TwoFactorAuthenticationRequest;
use Laravel\Fortify\Features;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * Show the user's two-factor authentication settings.
     */
    public function show(TwoFactorAuthenticationRequest $request)
    {
        $request->ensureStateIsValid();

        return response()->json([
            'twoFactorEnabled' => $request->user()->hasEnabledTwoFactorAuthentication(),
            'requiresConfirmation' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
        ]);
    }
}