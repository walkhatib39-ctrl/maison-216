<?php

namespace App\Support;

use App\Models\Setting;

class SiteSettings
{
    public static function phoneDisplay(): string
    {
        return (string) (Setting::get('contact.phone_display') ?: '96 813 203');
    }

    public static function phoneE164(): string
    {
        return (string) (Setting::get('contact.phone_e164') ?: '+21696813203');
    }

    public static function whatsappNumber(): string
    {
        return (string) (Setting::get('contact.whatsapp') ?: self::phoneE164());
    }

    public static function whatsappDigits(): ?string
    {
        $digits = preg_replace('/\D+/', '', self::whatsappNumber());

        if (!$digits) {
            return null;
        }

        if (strlen($digits) === 8) {
            return '216' . $digits;
        }

        return $digits;
    }

    public static function whatsappUrl(): ?string
    {
        $digits = self::whatsappDigits();

        return $digits ? 'https://wa.me/' . $digits : null;
    }

    public static function publicEmail(): string
    {
        return (string) (Setting::get('contact.public_email') ?: Setting::get('contact.admin_email') ?: 'admin@maison216.tn');
    }

    public static function adminEmails(): array
    {
        $raw = Setting::get('contact.admin_emails') ?: Setting::get('contact.admin_email') ?: 'admin@maison216.tn';

        if (is_array($raw)) {
            $emails = $raw;
        } else {
            $emails = preg_split('/[\s,;]+/', (string) $raw) ?: [];
        }

        return collect($emails)
            ->map(fn ($email) => trim((string) $email))
            ->filter(fn ($email) => $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    }

    public static function adminEmailsText(): string
    {
        return implode("\n", self::adminEmails());
    }

    public static function address(): string
    {
        return (string) (Setting::get('location.address') ?: 'Borj Cedria');
    }

    public static function city(): string
    {
        return (string) (Setting::get('location.city') ?: 'Borj Cedria');
    }

    public static function serviceArea(): string
    {
        return (string) (Setting::get('location.service_area') ?: 'Grand Tunis : Tunis, Ben Arous, Ariana, La Manouba');
    }

    public static function logoUrl(): ?string
    {
        return self::assetUrl(Setting::get('ui.logo'));
    }

    public static function faviconUrl(): ?string
    {
        return self::assetUrl(Setting::get('ui.favicon'));
    }

    public static function assetUrl(mixed $value): ?string
    {
        $path = trim((string) $value);

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        return asset($path);
    }
}
