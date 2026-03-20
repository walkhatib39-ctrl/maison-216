@php
    $blankItem = [
        'id' => null,
        'name' => '',
        'slug' => '',
        'code' => '',
        'room_id' => '',
        'description' => '',
        'position' => 0,
        'is_active' => true,
    ];

    foreach ($extraFields as $field) {
        $blankItem[$field['name']] = '';
    }

    $rooms = $rooms ?? collect();
    $showRoom = $showRoom ?? false;
@endphp

<div x-data="{
    isModalOpen: false,
    isDeleteModalOpen: false,
    mode: 'create',
    item: @js($blankItem),
    blankItem: @js($blankItem),
    deleteId: null,
    createUrl: @js($storeRoute),
    updateBaseUrl: @js($updateBaseUrl),
    destroyBaseUrl: @js($destroyBaseUrl),
    openCreate() {
        this.mode = 'create';
        this.item = JSON.parse(JSON.stringify(this.blankItem));
        this.isModalOpen = true;
    },
    openEdit(payload) {
        this.mode = 'edit';
        this.item = { ...JSON.parse(JSON.stringify(this.blankItem)), ...payload };
        this.isModalOpen = true;
    },
    openDelete(id) {
        this.deleteId = id;
        this.isDeleteModalOpen = true;
    },
    formAction() {
        return this.mode === 'create' ? this.createUrl : this.updateBaseUrl + '/' + this.item.id;
    },
    deleteAction() {
        return this.destroyBaseUrl + '/' + this.deleteId;
    }
}">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">{{ $pageTitle }}</h1>
            <p class="mt-1 text-dark-600">{{ $pageSubtitle }}</p>
        </div>
        <button @click="openCreate()" class="btn-premium inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2 text-white hover:bg-primary-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter {{ strtolower($entityNameSingular) }}
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            <div class="font-semibold">Le formulaire contient des erreurs :</div>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-dark-100 bg-white shadow-premium overflow-hidden">
        <table class="w-full text-left">
            <thead class="border-b border-dark-100 bg-dark-50 text-sm font-semibold text-dark-600">
                <tr>
                    <th class="px-6 py-4">{{ $entityNameSingular }}</th>
                    <th class="px-6 py-4">Contexte</th>
                    <th class="px-6 py-4">Utilisation</th>
                    <th class="px-6 py-4">Statut</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-100">
                @forelse($items as $item)
                    @php
                        $payload = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'slug' => $item->slug,
                            'code' => $item->code,
                            'room_id' => $item->room_id,
                            'description' => $item->description,
                            'position' => $item->position,
                            'is_active' => (bool) $item->is_active,
                        ];

                        foreach ($extraFields as $field) {
                            $payload[$field['name']] = $item->{$field['name']} ?? '';
                        }
                    @endphp
                    <tr class="group hover:bg-dark-50">
                        <td class="px-6 py-5 align-top">
                            <div class="font-semibold text-dark-900">{{ $item->name }}</div>
                            <div class="mt-1 text-sm font-mono text-dark-500">{{ $item->slug }}</div>
                        </td>
                        <td class="px-6 py-5 align-top">
                            <div class="space-y-2 text-sm text-dark-600">
                                @if($showRoom)
                                    <div>
                                        <span class="font-medium text-dark-800">Univers :</span>
                                        {{ $item->room?->name ?? '—' }}
                                    </div>
                                @endif
                                <div>
                                    <span class="font-medium text-dark-800">Code :</span>
                                    {{ $item->code ?: '—' }}
                                </div>
                                @foreach($extraFields as $field)
                                    @if(!empty($item->{$field['name']}))
                                        <div>
                                            <span class="font-medium text-dark-800">{{ $field['label'] }} :</span>
                                            {{ $item->{$field['name']} }}
                                        </div>
                                    @endif
                                @endforeach
                                <div>
                                    <span class="font-medium text-dark-800">Position :</span>
                                    {{ $item->position }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 align-top">
                            <div class="flex flex-wrap gap-2 text-xs font-semibold">
                                @if(isset($item->products_count))
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-blue-800">{{ $item->products_count }} produits</span>
                                @endif
                                @if(isset($item->categories_count))
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-amber-800">{{ $item->categories_count }} catégories</span>
                                @endif
                                @if(isset($item->product_types_count))
                                    <span class="rounded-full bg-purple-100 px-3 py-1 text-purple-800">{{ $item->product_types_count }} types</span>
                                @endif
                                @if(isset($item->collections_count))
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-emerald-800">{{ $item->collections_count }} collections</span>
                                @endif
                                @if(isset($item->primary_products_count))
                                    <span class="rounded-full bg-dark-100 px-3 py-1 text-dark-700">{{ $item->primary_products_count }} principales</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 align-top">
                            @if($item->is_active)
                                <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">
                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                    Actif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">
                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                    Inactif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 align-top text-right">
                            <div class="flex justify-end gap-2 opacity-0 transition-opacity group-hover:opacity-100">
                                <button type="button" @click='openEdit(@js($payload))' class="rounded-lg bg-primary-100 px-3 py-2 text-sm font-medium text-primary-700 hover:bg-primary-200">
                                    Modifier
                                </button>
                                <button type="button" @click="openDelete({{ $item->id }})" class="rounded-lg bg-red-100 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-200">
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="text-lg font-semibold text-dark-700">Aucun {{ strtolower($entityNameSingular) }} pour le moment</div>
                            <p class="mt-2 text-dark-500">Commencez par structurer le catalogue avec votre premier {{ strtolower($entityNameSingular) }}.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
            <div x-show="isModalOpen" @click="isModalOpen = false" x-transition.opacity class="fixed inset-0 bg-gray-900/70"></div>
            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <div x-show="isModalOpen" x-transition.scale class="inline-block w-full transform overflow-hidden rounded-2xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:max-w-2xl sm:align-middle">
                <form :action="formAction()" method="POST">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="border-b border-dark-100 px-6 py-5">
                        <h3 class="text-xl font-bold text-dark-900" x-text="mode === 'create' ? 'Créer {{ $entityNameSingular }}' : 'Modifier {{ $entityNameSingular }}'"></h3>
                        <p class="mt-1 text-sm text-dark-600">{{ $modalSubtitle }}</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-dark-700">Nom</label>
                            <input type="text" name="name" x-model="item.name" required class="w-full rounded-xl border-2 border-dark-200 px-4 py-3 focus:border-primary-500 focus:ring-0">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-dark-700">Slug</label>
                            <input type="text" name="slug" x-model="item.slug" class="w-full rounded-xl border-2 border-dark-200 px-4 py-3 font-mono focus:border-primary-500 focus:ring-0" placeholder="optionnel">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-dark-700">Code interne</label>
                            <input type="text" name="code" x-model="item.code" class="w-full rounded-xl border-2 border-dark-200 px-4 py-3 focus:border-primary-500 focus:ring-0" placeholder="ex: CHAMBRE">
                        </div>

                        @if($showRoom)
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-dark-700">Univers</label>
                                <select name="room_id" x-model="item.room_id" class="w-full rounded-xl border-2 border-dark-200 px-4 py-3 focus:border-primary-500 focus:ring-0">
                                    <option value="">— Aucun —</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-dark-700">Position</label>
                            <input type="number" name="position" min="0" x-model="item.position" class="w-full rounded-xl border-2 border-dark-200 px-4 py-3 focus:border-primary-500 focus:ring-0">
                        </div>

                        @foreach($extraFields as $field)
                            <div class="{{ $field['full'] ?? false ? 'md:col-span-2' : '' }}">
                                <label class="mb-2 block text-sm font-semibold text-dark-700">{{ $field['label'] }}</label>
                                <input type="text" name="{{ $field['name'] }}" x-model="item.{{ $field['name'] }}" class="w-full rounded-xl border-2 border-dark-200 px-4 py-3 focus:border-primary-500 focus:ring-0" placeholder="{{ $field['placeholder'] ?? '' }}">
                                @if(!empty($field['help']))
                                    <p class="mt-1 text-xs text-dark-500">{{ $field['help'] }}</p>
                                @endif
                            </div>
                        @endforeach

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-dark-700">Description</label>
                            <textarea name="description" rows="4" x-model="item.description" class="w-full rounded-xl border-2 border-dark-200 px-4 py-3 focus:border-primary-500 focus:ring-0" placeholder="Note interne, usage SEO ou intention métier."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="inline-flex items-center gap-3 rounded-xl border border-dark-200 bg-dark-50 px-4 py-3">
                                <input type="checkbox" name="is_active" value="1" x-model="item.is_active" class="h-5 w-5 rounded border-dark-300 text-primary-600 focus:ring-primary-500">
                                <span>
                                    <span class="block font-semibold text-dark-800">Élément actif</span>
                                    <span class="block text-sm text-dark-500">Disponible dans la future architecture catalogue.</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-dark-100 bg-dark-50 px-6 py-4 sm:flex-row sm:justify-end">
                        <button type="button" @click="isModalOpen = false" class="rounded-xl border border-dark-200 bg-white px-4 py-2 font-medium text-dark-700 hover:bg-dark-50">
                            Annuler
                        </button>
                        <button type="submit" class="rounded-xl bg-primary-600 px-4 py-2 font-semibold text-white hover:bg-primary-700">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="isDeleteModalOpen" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
        <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
            <div x-show="isDeleteModalOpen" @click="isDeleteModalOpen = false" x-transition.opacity class="fixed inset-0 bg-gray-900/70"></div>
            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <div x-show="isDeleteModalOpen" x-transition.scale class="inline-block w-full transform overflow-hidden rounded-2xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:max-w-lg sm:align-middle">
                <div class="px-6 py-5">
                    <h3 class="text-xl font-bold text-dark-900">Supprimer {{ strtolower($entityNameSingular) }} ?</h3>
                    <p class="mt-2 text-sm text-dark-600">
                        Cette action est irréversible. Si l’élément est déjà lié au catalogue, la suppression sera bloquée.
                    </p>
                </div>
                <div class="flex flex-col-reverse gap-3 border-t border-dark-100 bg-dark-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <button type="button" @click="isDeleteModalOpen = false" class="rounded-xl border border-dark-200 bg-white px-4 py-2 font-medium text-dark-700 hover:bg-dark-50">
                        Annuler
                    </button>
                    <form :action="deleteAction()" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-xl bg-red-600 px-4 py-2 font-semibold text-white hover:bg-red-700">
                            Confirmer la suppression
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
