<?php

namespace App\Support;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadCapture
{
    public function createFromContactForm(Request $request, array $data): Lead
    {
        $type = $this->resolveType($data);
        $sourceUrl = $request->headers->get('referer') ?: $request->fullUrl();
        $sourcePath = $this->pathFromUrl($sourceUrl);

        return Lead::create([
            'type' => $type,
            'source_page_path' => $sourcePath,
            'source_url' => $sourceUrl,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'profession' => $data['profession'] ?? null,
            'subject' => $data['subject'] ?? $this->defaultSubject($type),
            'message' => $data['message'] ?? null,
            'payload' => [
                'location' => $data['location'] ?? null,
                'project_type' => $data['project_type'] ?? null,
                'has_project' => $data['has_project'] ?? null,
                'ip' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
            ],
            'status' => Lead::STATUS_NEW,
            'priority' => $type === Lead::TYPE_PROFESSIONAL ? Lead::PRIORITY_HIGH : Lead::PRIORITY_NORMAL,
        ]);
    }

    private function resolveType(array $data): string
    {
        $subject = mb_strtolower((string) ($data['subject'] ?? ''), 'UTF-8');

        if (filled($data['profession'] ?? null) || str_contains($subject, 'professionnel')) {
            return Lead::TYPE_PROFESSIONAL;
        }

        if (str_contains($subject, 'devis') || filled($data['project_type'] ?? null)) {
            return Lead::TYPE_QUOTE;
        }

        return Lead::TYPE_CONTACT;
    }

    private function defaultSubject(string $type): string
    {
        return match ($type) {
            Lead::TYPE_QUOTE => 'Demande de devis',
            Lead::TYPE_PROFESSIONAL => 'Demande espace professionnels',
            default => 'Message de contact',
        };
    }

    private function pathFromUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);

        if (!is_string($path)) {
            return null;
        }

        return trim($path, '/') ?: '/';
    }
}
