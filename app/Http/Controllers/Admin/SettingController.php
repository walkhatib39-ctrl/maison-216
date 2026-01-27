<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $data = [
            'site_name' => Setting::get('site.name', 'Maison 216'),
            'site_tagline' => Setting::get('site.tagline', 'Meubles & Décoration en Tunisie'),

            'whatsapp' => Setting::get('contact.whatsapp', ''),
            'messenger' => Setting::get('contact.messenger', ''),
            'admin_email' => Setting::get('contact.admin_email', 'admin@maison216.tn'),

            'shipping_fee_millimes' => (int) (Setting::get('shipping.fee_millimes', 20000) ?? 20000),

            'checkout_whatsapp_enabled' => (bool) (Setting::get('checkout.whatsapp_enabled', true) ?? true),
            'checkout_messenger_enabled' => (bool) (Setting::get('checkout.messenger_enabled', true) ?? true),

            'ui_logo' => Setting::get('ui.logo', null),
            'ui_favicon' => Setting::get('ui.favicon', null),
        ];

        return view('admin.settings.index', ['s' => $data]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],

            'whatsapp' => ['nullable', 'string', 'max:255'],
            'messenger' => ['nullable', 'string', 'max:255'],
            'admin_email' => ['nullable', 'email', 'max:255'],

            'shipping_fee' => ['required', 'string', 'max:50'], // in DT (e.g. "20" or "20 DT")

            'checkout_whatsapp_enabled' => ['nullable', 'boolean'],
            'checkout_messenger_enabled' => ['nullable', 'boolean'],

            'ui_logo_url' => ['nullable', 'url'],
            'ui_favicon_url' => ['nullable', 'url'],

            'ui_logo_file' => ['nullable', 'image', 'max:4096'],
            'ui_favicon_file' => ['nullable', 'mimes:png,ico', 'max:1024'],
        ]);

        // Convert DT string to millimes int
        $shippingFeeMillimes = $this->parsePriceToMillimes((string) $data['shipping_fee']);

        // Handle uploads (stored on public disk)
        $logoUrl = null;
        if ($request->hasFile('ui_logo_file')) {
            $path = $request->file('ui_logo_file')->store('public/ui');
            $logoUrl = Storage::url($path);
        } elseif (!empty($data['ui_logo_url'])) {
            $logoUrl = $data['ui_logo_url'];
        }

        $faviconUrl = null;
        if ($request->hasFile('ui_favicon_file')) {
            $path = $request->file('ui_favicon_file')->store('public/ui');
            $faviconUrl = Storage::url($path);
        } elseif (!empty($data['ui_favicon_url'])) {
            $faviconUrl = $data['ui_favicon_url'];
        }

        // Persist settings
        Setting::set('site.name', (string) $data['site_name'], 'site');
        Setting::set('site.tagline', (string) ($data['site_tagline'] ?? ''), 'site');

        Setting::set('contact.whatsapp', (string) ($data['whatsapp'] ?? ''), 'contact');
        Setting::set('contact.messenger', (string) ($data['messenger'] ?? ''), 'contact');
        if (!empty($data['admin_email'])) {
            Setting::set('contact.admin_email', (string) $data['admin_email'], 'contact');
        }

        Setting::set('shipping.fee_millimes', (int) $shippingFeeMillimes, 'shipping');

        Setting::set('checkout.whatsapp_enabled', (bool) ($data['checkout_whatsapp_enabled'] ?? false), 'checkout');
        Setting::set('checkout.messenger_enabled', (bool) ($data['checkout_messenger_enabled'] ?? false), 'checkout');

        if ($logoUrl !== null) {
            Setting::set('ui.logo', $logoUrl, 'ui');
        }
        if ($faviconUrl !== null) {
            Setting::set('ui.favicon', $faviconUrl, 'ui');
        }

        return back()->with('status', 'Paramètres enregistrés.');
    }

    protected function parsePriceToMillimes(string $price): int
    {
        $price = trim($price);
        if ($price === '') {
            return 0;
        }
        $clean = preg_replace('/[^0-9,\.]/u', '', $price);
        if ($clean === null || $clean === '') {
            return 0;
        }
        $clean = str_replace([' ', "\u{00A0}"], '', $clean);
        if (str_contains($clean, ',') && str_contains($clean, '.')) {
            $clean = str_replace('.', '', $clean);
        }
        $clean = str_replace(',', '.', $clean);

        $value = (float) $clean;
        return (int) round($value * 1000);
    }
}
