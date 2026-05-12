<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    public function index()
    {
        $data = [
            'site_name' => Setting::get('site.name', 'Maison 216'),
            'site_tagline' => Setting::get('site.tagline', 'Atelier integre bois, aluminium et metal en Tunisie'),

            'phone_display' => SiteSettings::phoneDisplay(),
            'phone_e164' => SiteSettings::phoneE164(),
            'whatsapp' => SiteSettings::whatsappNumber(),
            'public_email' => SiteSettings::publicEmail(),
            'admin_emails' => SiteSettings::adminEmailsText(),
            'messenger' => Setting::get('contact.messenger', ''),

            'address' => SiteSettings::address(),
            'city' => SiteSettings::city(),
            'service_area' => SiteSettings::serviceArea(),

            'facebook' => Setting::get('social.facebook', ''),
            'instagram' => Setting::get('social.instagram', ''),
            'tiktok' => Setting::get('social.tiktok', ''),
            'linkedin' => Setting::get('social.linkedin', ''),
            'youtube' => Setting::get('social.youtube', ''),

            'google_site_verification' => Setting::get('seo.google_site_verification', ''),
            'bing_site_verification' => Setting::get('seo.bing_site_verification', ''),
            'seo_og_image' => Setting::get('seo.og_image', ''),

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

            'phone_display' => ['nullable', 'string', 'max:80'],
            'phone_e164' => ['nullable', 'string', 'max:40'],
            'whatsapp' => ['nullable', 'string', 'max:40'],
            'public_email' => ['nullable', 'email', 'max:255'],
            'admin_emails' => ['nullable', 'string', 'max:1200'],
            'messenger' => ['nullable', 'url', 'max:255'],

            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:120'],
            'service_area' => ['nullable', 'string', 'max:500'],

            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'tiktok' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],

            'google_site_verification' => ['nullable', 'string', 'max:255'],
            'bing_site_verification' => ['nullable', 'string', 'max:255'],
            'seo_og_image_url' => ['nullable', 'string', 'max:255'],

            'ui_logo_url' => ['nullable', 'string', 'max:255'],
            'ui_favicon_url' => ['nullable', 'string', 'max:255'],

            'ui_logo_file' => ['nullable', 'image', 'max:4096'],
            'ui_favicon_file' => ['nullable', 'mimes:png,ico,svg', 'max:1024'],
            'seo_og_image_file' => ['nullable', 'image', 'max:4096'],
        ]);

        $adminEmails = $this->parseEmails((string) ($data['admin_emails'] ?? ''));
        $this->validateAssetPath('ui_logo_url', $data['ui_logo_url'] ?? null);
        $this->validateAssetPath('ui_favicon_url', $data['ui_favicon_url'] ?? null);
        $this->validateAssetPath('seo_og_image_url', $data['seo_og_image_url'] ?? null);

        if (($data['admin_emails'] ?? '') !== '' && $adminEmails === []) {
            throw ValidationException::withMessages([
                'admin_emails' => 'Ajoutez au moins un email de reception valide.',
            ]);
        }

        $logoUrl = $this->resolveUploadOrUrl($request, 'ui_logo_file', $data['ui_logo_url'] ?? null, 'public/ui');
        $faviconUrl = $this->resolveUploadOrUrl($request, 'ui_favicon_file', $data['ui_favicon_url'] ?? null, 'public/ui');
        $ogImageUrl = $this->resolveUploadOrUrl($request, 'seo_og_image_file', $data['seo_og_image_url'] ?? null, 'public/seo');

        Setting::set('site.name', (string) $data['site_name'], 'site');
        Setting::set('site.tagline', (string) ($data['site_tagline'] ?? ''), 'site');

        Setting::set('contact.phone_display', (string) ($data['phone_display'] ?? ''), 'contact');
        Setting::set('contact.phone_e164', (string) ($data['phone_e164'] ?? ''), 'contact');
        Setting::set('contact.whatsapp', (string) ($data['whatsapp'] ?? ''), 'contact');
        Setting::set('contact.public_email', (string) ($data['public_email'] ?? ''), 'contact');
        Setting::set('contact.admin_emails', implode("\n", $adminEmails), 'contact');
        Setting::set('contact.admin_email', $adminEmails[0] ?? (string) ($data['public_email'] ?? ''), 'contact');
        Setting::set('contact.messenger', (string) ($data['messenger'] ?? ''), 'contact');

        Setting::set('location.address', (string) ($data['address'] ?? ''), 'location');
        Setting::set('location.city', (string) ($data['city'] ?? ''), 'location');
        Setting::set('location.service_area', (string) ($data['service_area'] ?? ''), 'location');

        foreach (['facebook', 'instagram', 'tiktok', 'linkedin', 'youtube'] as $network) {
            Setting::set('social.' . $network, (string) ($data[$network] ?? ''), 'social');
        }

        Setting::set('seo.google_site_verification', trim((string) ($data['google_site_verification'] ?? '')), 'seo');
        Setting::set('seo.bing_site_verification', trim((string) ($data['bing_site_verification'] ?? '')), 'seo');

        if ($logoUrl !== null) {
            Setting::set('ui.logo', $logoUrl, 'ui');
        }

        if ($faviconUrl !== null) {
            Setting::set('ui.favicon', $faviconUrl, 'ui');
        }

        if ($ogImageUrl !== null) {
            Setting::set('seo.og_image', $ogImageUrl, 'seo');
        }

        return back()->with('status', 'Parametres enregistres.');
    }

    protected function parseEmails(string $raw): array
    {
        return collect(preg_split('/[\s,;]+/', $raw) ?: [])
            ->map(fn ($email) => trim((string) $email))
            ->filter(fn ($email) => $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    }

    protected function resolveUploadOrUrl(Request $request, string $fileKey, ?string $url, string $directory): ?string
    {
        if ($request->hasFile($fileKey)) {
            $path = $request->file($fileKey)->store($directory);

            return Storage::url($path);
        }

        $url = trim((string) $url);

        return $url !== '' ? $url : null;
    }

    protected function validateAssetPath(string $field, ?string $value): void
    {
        $value = trim((string) $value);

        if ($value === '') {
            return;
        }

        if (str_starts_with($value, '/') || str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return;
        }

        if (!str_contains($value, ':') && !str_contains($value, '<')) {
            return;
        }

        throw ValidationException::withMessages([
            $field => 'Utilisez une URL https:// ou un chemin image valide.',
        ]);
    }
}
