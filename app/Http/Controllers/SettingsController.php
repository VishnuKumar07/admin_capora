<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Support\Facades\File;

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

    public function tax()
    {
        $taxsettings = Settings::where('category', 'tax')->pluck('value', 'setting_key')->toArray();
        return view('settings.tax', compact('taxsettings'));
    }

    public function updateTaxDetails(Request $request)
    {
        $request->validate([
            'gst_enabled' => 'required|in:0,1',
            'gst_type'    => 'nullable|in:percentage,flat',
            'gst_value'   => 'nullable|numeric|min:0',
            'gst_number'  => 'nullable|string|max:20',
        ]);

        $settings = [
            'gst_enabled' => $request->gst_enabled,
            'gst_type'    => $request->gst_type,
            'gst_value'   => $request->gst_value,
            'gst_number'  => $request->gst_number,
        ];

        foreach ($settings as $key => $value) {
            Settings::updateOrCreate(
                ['setting_key' => $key],
                ['category' => 'tax', 'value' => $value]
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'GST settings updated successfully'
        ]);
    }

    public function company()
    {
        $companysettings = Settings::where('category', 'company')->pluck('value', 'setting_key')->toArray();
        return view('settings.company', compact('companysettings'));
    }
    
    public function updateCompany(Request $request)
    {
        try {

            $request->validate([
                'company_name'    => 'required|string|max:255',
                'company_email'   => 'required|email',
                'company_phone'   => 'required|string|max:20',
                'company_address' => 'required|string',
                'company_city'    => 'required|string|max:100',
                'company_pincode' => 'required|string|max:10',
            ]);

            $fields = [
                'company_name',
                'company_email',
                'company_phone',
                'company_address',
                'company_city',
                'company_state',
                'company_pincode',
                'company_country',
            ];

            foreach ($fields as $field) {
                Settings::updateOrCreate(
                    ['setting_key' => $field],
                    [
                        'category' => 'company',
                        'value'    => $request->$field
                    ]
                );
            }

            if ($request->hasFile('company_logo')) {
                $logoDir  = public_path('images');
                $logoPath = $logoDir . '/logo.png';
                if (!File::exists($logoDir)) {
                    File::makeDirectory($logoDir, 0755, true);
                }
                if (File::exists($logoPath)) {
                    File::delete($logoPath);
                }
                $request->file('company_logo')->move($logoDir, 'logo.png');
                Settings::updateOrCreate(
                    ['setting_key' => 'company_logo'],
                    [
                        'category' => 'company',
                        'value'    => 'images/logo.png'
                    ]
                );
            }

            return response()->json([
                'status'  => true,
                'message' => 'Company settings updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Update failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

}
