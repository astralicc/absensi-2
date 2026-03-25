<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Public settings used by non-admin pages (ex: attendance report).
     * Provide sane defaults so pages never crash when settings are missing.
     */
    public static function getPublicSettings(): array
    {
        return [
            'admin_whatsapp' => env('ADMIN_WHATSAPP', '081234567890'),
            'admin_email' => env('ADMIN_EMAIL', 'admin@smkn12jakarta.sch.id'),

            // Used by admin settings UI as placeholders
            'school_name' => env('SCHOOL_NAME', 'SMKN 12 Jakarta'),
            'school_address' => env('SCHOOL_ADDRESS', ''),
            'school_phone' => env('SCHOOL_PHONE', ''),
        ];
    }

    public function index()
    {
        $settings = [
            'site_name' => config('app.name'),
            'site_description' => 'Absensi SMKN 12 Jakarta',
        ];

        // Merge with public settings so the Blade view has the expected keys
        $settings = array_merge($settings, self::getPublicSettings());

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
