<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\WorkshopClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->get('q', '')),
            'client_type' => (string) $request->get('client_type', ''),
        ];

        $clients = WorkshopClient::query()
            ->withCount('orders')
            ->when($filters['q'] !== '', function ($query) use ($filters) {
                $q = $filters['q'];
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhere('whatsapp', 'like', "%{$q}%")
                        ->orWhere('city', 'like', "%{$q}%");
                });
            })
            ->when($filters['client_type'] !== '', fn ($query) => $query->where('client_type', $filters['client_type']))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('workshop.clients.index', [
            'clients' => $clients,
            'filters' => $filters,
            'clientTypes' => WorkshopClient::clientTypes(),
        ]);
    }

    public function create(): View
    {
        return view('workshop.clients.form', [
            'client' => new WorkshopClient(['client_type' => WorkshopClient::TYPE_INDIVIDUAL]),
            'clientTypes' => WorkshopClient::clientTypes(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $client = WorkshopClient::create($this->validatedData($request));

        return redirect()
            ->route('workshop.clients.show', $client)
            ->with('status', 'Client ajouté.');
    }

    public function show(WorkshopClient $client): View
    {
        $client->load(['orders' => fn ($query) => $query->latest('delivery_due_at')->latest()]);

        return view('workshop.clients.show', compact('client'));
    }

    public function edit(WorkshopClient $client): View
    {
        return view('workshop.clients.form', [
            'client' => $client,
            'clientTypes' => WorkshopClient::clientTypes(),
        ]);
    }

    public function update(Request $request, WorkshopClient $client): RedirectResponse
    {
        $client->update($this->validatedData($request));

        return redirect()
            ->route('workshop.clients.show', $client)
            ->with('status', 'Client mis à jour.');
    }

    public function destroy(WorkshopClient $client): RedirectResponse
    {
        $client->delete();

        return redirect()
            ->route('workshop.clients.index')
            ->with('status', 'Client supprimé. Ses commandes restent conservées.');
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'whatsapp' => ['nullable', 'string', 'max:40'],
            'city' => ['nullable', 'string', 'max:120'],
            'address' => ['nullable', 'string', 'max:1000'],
            'client_type' => ['required', 'string', 'in:' . implode(',', array_keys(WorkshopClient::clientTypes()))],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }
}
