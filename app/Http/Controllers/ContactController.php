<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact.index', [
            'title' => 'Contact',
            'metaDescription' => 'Contactez-nous par WhatsApp, Messenger ou via le formulaire. Réponse rapide 7j/7.',
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $tnPattern = '^(?:\+?216\s*)?(?:[24579]\d{7}|[24579]\d\s\d{3}\s\d{3})$';

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:120'],
            'email'        => ['required', 'email', 'max:150'],
            'phone'        => ['nullable', 'string', 'max:30', "regex:/{$tnPattern}/"],
            'message'      => ['required', 'string', 'max:3000'],
            'subject'      => ['nullable', 'string', 'max:160'],
            'company'      => ['nullable', 'string', 'max:160'],
            'profession'   => ['nullable', 'string', 'max:120'],
            'location'     => ['nullable', 'string', 'max:160'],
            'project_type' => ['nullable', 'string', 'max:600'],
            'has_project'  => ['nullable', 'string', 'max:20'],
        ], [
            'name.required'    => 'Votre nom est obligatoire.',
            'email.required'   => 'Votre email est obligatoire.',
            'email.email'      => 'Adresse email invalide.',
            'phone.regex'      => 'Le téléphone doit être un numéro tunisien valide (ex : 55 123 456).',
            'message.required' => 'Veuillez saisir votre message.',
        ]);

        // Build email content
        $adminEmail = (string) (Setting::get('contact.admin_email', '') ?? '');
        if (!empty($adminEmail)) {
            try {
                Mail::send('emails.contact', [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'messageBody' => $data['message'],
                    'subjectLine' => $data['subject'] ?? 'Nouveau message de contact',
                    'company' => $data['company'] ?? null,
                    'profession' => $data['profession'] ?? null,
                    'location' => $data['location'] ?? null,
                    'projectType' => $data['project_type'] ?? null,
                    'hasProject' => $data['has_project'] ?? null,
                    'ip' => $request->ip(),
                    'ua' => (string) $request->userAgent(),
                ], function ($m) use ($adminEmail, $data) {
                    $m->to($adminEmail)->subject(($data['subject'] ?? 'Nouveau message de contact') . ' — Maison 216');
                });
            } catch (\Throwable $e) {
                logger()->warning('Contact email failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Merci, votre message a été envoyé. Nous vous répondrons rapidement.');
    }
}
