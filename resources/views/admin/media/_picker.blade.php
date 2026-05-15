<div id="media-picker-modal" class="fixed inset-0 z-[80] hidden bg-black/55 p-3 sm:p-6" aria-hidden="true">
    <div class="mx-auto flex h-full max-w-6xl flex-col overflow-hidden rounded-[28px] bg-[#fbf7f0] shadow-2xl">
        <div class="flex flex-col gap-4 border-b border-[#eadfce] bg-white p-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-lg font-extrabold text-[#171411]">Choisir depuis la mediatheque</div>
                <div class="text-xs font-semibold text-[#6a5a4c]">Selectionnez une image existante ou uploadez un nouveau fichier.</div>
            </div>
            <button type="button" data-media-close class="rounded-xl border border-[#d8c7af] px-4 py-2 text-sm font-extrabold text-[#171411]">Fermer</button>
        </div>

        <div class="grid gap-3 border-b border-[#eadfce] bg-[#fbf7f0] p-4 lg:grid-cols-[1fr_auto]">
            <input id="media-picker-search" type="search" placeholder="Rechercher une image..." class="rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
            <form id="media-picker-upload" class="flex flex-col gap-2 sm:flex-row">
                <input name="media_files[]" type="file" multiple accept="image/*,.ico,.svg" class="rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-[#171411] file:px-3 file:py-2 file:text-xs file:font-bold file:text-white">
                <button class="rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-extrabold text-white">Uploader</button>
            </form>
        </div>

        <div id="media-picker-status" class="hidden border-b border-[#eadfce] px-4 py-3 text-sm font-semibold"></div>

        <div id="media-picker-grid" class="grid flex-1 content-start gap-3 overflow-y-auto p-4 sm:grid-cols-2 lg:grid-cols-4"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('media-picker-modal');
    const grid = document.getElementById('media-picker-grid');
    const search = document.getElementById('media-picker-search');
    const uploadForm = document.getElementById('media-picker-upload');
    const status = document.getElementById('media-picker-status');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    let activeConfig = null;
    let searchTimer = null;

    const escapeHtml = (value) => String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    const showStatus = (message, type = 'info') => {
        if (!status) return;
        status.textContent = message;
        status.className = 'border-b border-[#eadfce] px-4 py-3 text-sm font-semibold ' + (type === 'error' ? 'bg-rose-50 text-rose-800' : 'bg-emerald-50 text-emerald-800');
    };

    const hideStatus = () => {
        if (!status) return;
        status.className = 'hidden border-b border-[#eadfce] px-4 py-3 text-sm font-semibold';
        status.textContent = '';
    };

    const render = (assets) => {
        if (!grid) return;
        if (!assets.length) {
            grid.innerHTML = '<div class="col-span-full rounded-2xl border border-dashed border-[#d8c7af] bg-white px-5 py-12 text-center text-sm font-bold text-[#6a5a4c]">Aucune image trouvee.</div>';
            return;
        }

        grid.innerHTML = assets.map((asset) => `
            <button type="button" data-media-select="${escapeHtml(asset.path)}" data-media-url="${escapeHtml(asset.url)}" class="group overflow-hidden rounded-2xl border border-[#eadfce] bg-white text-left shadow-sm transition hover:-translate-y-0.5 hover:border-[#b88a3b]">
                <img src="${escapeHtml(asset.url)}" alt="${escapeHtml(asset.filename)}" loading="lazy" class="aspect-[4/3] w-full bg-[#e8ddce] object-cover">
                <span class="block space-y-1 p-3">
                    <span class="block truncate text-sm font-extrabold text-[#171411]">${escapeHtml(asset.filename)}</span>
                    <span class="block text-xs font-semibold text-[#6a5a4c]">${escapeHtml(asset.dimensions || 'Dimensions non lues')} · ${escapeHtml(asset.size)}</span>
                    <span class="block truncate text-[11px] font-semibold text-[#a47834]">${escapeHtml(asset.path)}</span>
                </span>
            </button>
        `).join('');
    };

    const loadAssets = async () => {
        if (!grid) return;
        grid.innerHTML = '<div class="col-span-full rounded-2xl bg-white px-5 py-12 text-center text-sm font-bold text-[#6a5a4c]">Chargement...</div>';
        const query = new URLSearchParams({ q: search?.value || '' });
        const response = await fetch(`{{ route('admin.media.picker') }}?${query.toString()}`, { headers: { 'Accept': 'application/json' } });
        const data = await response.json();
        render(data.assets || []);
    };

    const setTargetValue = (path, url) => {
        if (!activeConfig?.target) return;
        const target = document.querySelector(activeConfig.target);
        if (!target) return;

        if (activeConfig.mode === 'append') {
            const current = String(target.value || '').trim();
            target.value = current ? `${current}\n${path}` : path;
        } else {
            target.value = path;
        }

        target.dispatchEvent(new Event('input', { bubbles: true }));
        target.dispatchEvent(new Event('change', { bubbles: true }));

        if (activeConfig.preview) {
            const preview = document.querySelector(activeConfig.preview);
            if (preview) {
                preview.classList.remove('hidden');
                preview.innerHTML = `<img src="${escapeHtml(url)}" alt="" class="aspect-[4/3] h-full w-full object-cover">`;
            }
        }

        modal?.classList.add('hidden');
        modal?.setAttribute('aria-hidden', 'true');
        hideStatus();
    };

    document.querySelectorAll('[data-media-picker]').forEach((button) => {
        button.addEventListener('click', async () => {
            activeConfig = {
                target: button.getAttribute('data-media-target'),
                mode: button.getAttribute('data-media-mode') || 'replace',
                preview: button.getAttribute('data-media-preview') || '',
            };
            modal?.classList.remove('hidden');
            modal?.setAttribute('aria-hidden', 'false');
            await loadAssets();
            search?.focus();
        });
    });

    document.querySelectorAll('[data-media-close]').forEach((button) => {
        button.addEventListener('click', () => {
            modal?.classList.add('hidden');
            modal?.setAttribute('aria-hidden', 'true');
            hideStatus();
        });
    });

    modal?.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            hideStatus();
        }
    });

    grid?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-media-select]');
        if (!button) return;
        setTargetValue(button.getAttribute('data-media-select'), button.getAttribute('data-media-url'));
    });

    search?.addEventListener('input', () => {
        window.clearTimeout(searchTimer);
        searchTimer = window.setTimeout(loadAssets, 250);
    });

    uploadForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(uploadForm);
        showStatus('Upload en cours...');
        const response = await fetch('{{ route('admin.media.upload') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
            },
            body: formData,
        });

        if (!response.ok) {
            showStatus('Upload impossible. Verifiez le format ou la taille du fichier.', 'error');
            return;
        }

        uploadForm.reset();
        showStatus('Image ajoutee a la mediatheque.');
        await loadAssets();
    });

    document.querySelectorAll('[data-copy-media]').forEach((button) => {
        button.addEventListener('click', async () => {
            const path = button.getAttribute('data-copy-media') || '';
            try {
                await navigator.clipboard.writeText(path);
                button.textContent = 'Copie';
                window.setTimeout(() => button.textContent = 'Copier chemin', 1200);
            } catch {
                button.textContent = path;
            }
        });
    });
});
</script>
