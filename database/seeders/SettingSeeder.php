<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Identite du site
        Setting::set('site.name', 'Maison 216', 'site');
        Setting::set('site.tagline', 'Atelier integre bois, aluminium et metal en Tunisie', 'site');

        // Contact et notifications
        Setting::set('contact.phone_display', '96 813 203', 'contact');
        Setting::set('contact.phone_e164', '+21696813203', 'contact');
        Setting::set('contact.whatsapp', '+21696813203', 'contact');
        Setting::set('contact.public_email', 'admin@maison216.tn', 'contact');
        Setting::set('contact.admin_emails', "admin@maison216.tn", 'contact');
        Setting::set('contact.admin_email', 'admin@maison216.tn', 'contact');
        Setting::set('contact.messenger', '', 'contact');

        // Localisation
        Setting::set('location.address', 'Borj Cedria', 'location');
        Setting::set('location.city', 'Borj Cedria', 'location');
        Setting::set('location.service_area', 'Grand Tunis : Tunis, Ben Arous, Ariana, La Manouba', 'location');

        // Reseaux sociaux
        Setting::set('social.facebook', '', 'social');
        Setting::set('social.instagram', '', 'social');
        Setting::set('social.tiktok', '', 'social');
        Setting::set('social.linkedin', '', 'social');
        Setting::set('social.youtube', '', 'social');

        // Livraison (frais fixe national)
        Setting::set('shipping.fee_millimes', 20000, 'shipping'); // 20 DT

        // Checkout options (boutons rapides)
        Setting::set('checkout.whatsapp_enabled', true, 'checkout');
        Setting::set('checkout.messenger_enabled', true, 'checkout');

        // UI (placeholders modifiables)
        Setting::set('ui.logo', null, 'ui');     // URL ou chemin storage
        Setting::set('ui.favicon', null, 'ui');  // URL ou chemin

        // SEO / outils
        Setting::set('seo.currency', 'TND', 'seo'); // Affichage "DT"
        Setting::set('seo.locale', 'fr_TN', 'seo');
        Setting::set('seo.google_site_verification', '', 'seo');
        Setting::set('seo.bing_site_verification', '', 'seo');
        Setting::set('seo.og_image', null, 'seo');
    }
}
