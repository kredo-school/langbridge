document.addEventListener("click", (e) => {
    const btn = e.target.closest(".open-vocab-modal");
    if (!btn) return;

    document.dispatchEvent(
        new CustomEvent("openVocabularyModal", {
            detail: {
                vocabularyId: btn.dataset.id,
                front: btn.dataset.front,
                back: btn.dataset.back,
                note: btn.dataset.note,
            }
        })
    );
});

document.addEventListener('openVocabularyModal', function(event) {
    const wrapper = document.getElementById("vocab-modal-component");
    if (!wrapper) return;

    const componentId = wrapper.dataset.componentId;

    const livewireGlobal = window.Livewire || window.livewire;
    if (!livewireGlobal) {
        console.error('Livewire is not available on window.');
        return;
    }

    const component = livewireGlobal.find(componentId);
    if (!component) {
        console.error('Livewire component not found for id:', componentId);
        return;
    }

    const detail = event && event.detail ? event.detail : {};

    component.call(
        'open',
        detail.front || '',
        detail.back || '',
        detail.vocabularyId || null,
        detail.note || ''
    );
});


