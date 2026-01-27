<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Identité du site
        Setting::set('site.name', 'Maison 216', 'site');
        Setting::set('site.tagline', 'Meubles & Décoration en Tunisie', 'site');

        // Contact (configurable dans l’admin)
        Setting::set('contact.whatsapp', '', 'contact');   // ex: "+216 20 000 000"
        Setting::set('contact.messenger', '', 'contact');  // ex: "https://m.me/maison216"
        Setting::set('contact.admin_email', 'admin@maison216.tn', 'contact'); // réception notifications

        // Livraison (frais fixe national)
        Setting::set('shipping.fee_millimes', 20000, 'shipping'); // 20 DT

        // Checkout options (boutons rapides)
        Setting::set('checkout.whatsapp_enabled', true, 'checkout');
        Setting::set('checkout.messenger_enabled', true, 'checkout');

        // UI (placeholders modifiables)
        Setting::set('ui.logo', null, 'ui');     // URL ou chemin storage
        Setting::set('ui.favicon', null, 'ui');  // URL ou chemin

        // SEO / devise
        Setting::set('seo.currency', 'TND', 'seo'); // Affichage "DT"
        Setting::set('seo.locale', 'fr_TN', 'seo');
    }
}
