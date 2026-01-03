<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function paymentMethods()
    {
        $settings = Settings::where('category', 'payment')->pluck('value', 'setting_key')->toArray();
        return view('settings.payment_method', compact('settings'));
    }

    public function updatepaymentMethods(Request $request)
    {

        $request->validate([
            'key'   => 'required|in:payment_online,payment_cod',
            'value' => 'required|in:0,1',
        ]);

        Settings::updateOrCreate(
            ['setting_key' => $request->key],
            [
                'category' => 'payment',
                'value'    => $request->value
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Payment setting updated successfully'
        ]);
    }
}
