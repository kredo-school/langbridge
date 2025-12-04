<div x-data="{ open: @entangle('isOpen') }">
    <div x-show="open" class="modal-backdrop" style="display: flex;">
        <div class="modal-content">
            <h2>{{ $vocabularyId ? __('messages.edit_vocabulary') : __('messages.add_vocabulary') }}</h2>

            <input type="text" wire:model="front" placeholder="{{ __('messages.front') }}">
            <input type="text" wire:model="back" placeholder="{{ __('messages.back') }}">
            <textarea wire:model="note" placeholder="{{ __('messages.note') . '(' . __('messages.optional') . ')' }}"></textarea>

            <!-- Add/Edit 切り替えボタン -->
            <button 
                wire:click="save" 
                :class="$vocabularyId ? 'btn-edit' : 'btn-add'">
                {{ $vocabularyId ? __('messages.update') : __('messages.add') }}
            </button>

            <!-- Cancel は共通 -->
            <button wire:click="close" class="btn-cancel">{{ __('messages.cancel') }}</button>
        </div>
    </div>
</div>