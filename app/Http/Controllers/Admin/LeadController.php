<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'type' => (string) $request->query('type', ''),
            'status' => (string) $request->query('status', ''),
            'priority' => (string) $request->query('priority', ''),
        ];

        $query = Lead::query()->latest();

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('company', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%")
                    ->orWhere('source_page_path', 'like', "%{$q}%");
            });
        }

        if ($filters['type'] !== '') {
            $query->where('type', $filters['type']);
        }

        if ($filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if ($filters['priority'] !== '') {
            $query->where('priority', $filters['priority']);
        }

        return view('admin.leads.index', [
            'leads' => $query->paginate(20)->withQueryString(),
            'filters' => $filters,
            'types' => Lead::types(),
            'statuses' => Lead::statuses(),
            'priorities' => Lead::priorities(),
            'stats' => [
                'new' => Lead::query()->where('status', Lead::STATUS_NEW)->count(),
                'open' => Lead::query()->open()->count(),
                'professional' => Lead::query()->where('type', Lead::TYPE_PROFESSIONAL)->open()->count(),
                'quote' => Lead::query()->where('type', Lead::TYPE_QUOTE)->open()->count(),
            ],
        ]);
    }

    public function show(Lead $lead)
    {
        return view('admin.leads.show', [
            'lead' => $lead,
            'statuses' => Lead::statuses(),
            'priorities' => Lead::priorities(),
        ]);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Lead::statuses()))],
            'priority' => ['required', Rule::in(array_keys(Lead::priorities()))],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $wasContacted = $lead->status === Lead::STATUS_CONTACTED;

        $lead->fill($data);

        if (!$wasContacted && $data['status'] === Lead::STATUS_CONTACTED) {
            $lead->last_contacted_at = now();
        }

        $lead->save();

        return back()->with('status', 'Demande mise a jour.');
    }
}
