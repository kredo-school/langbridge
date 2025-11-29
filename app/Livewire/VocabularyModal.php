<?php

namespace App\Livewire;

use Livewire\Component;


class VocabularyModal extends Component
{
    public $front = '';
    public $back = '';
    public $note = '';
    public $vocabularyId = null; // 編集時は既存の単語IDを入れる
    public $isOpen = false;      // モーダル表示フラグ

    // モーダルを開く
    public function open($front = '', $back = '', $vocabularyId = null)
    {
        $this->front = $front;
        $this->back = $back;
        $this->note = '';
        $this->vocabularyId = $vocabularyId;
        $this->isOpen = true;
    }

    // 保存処理
    public function save()
    {
        $this->validate([
            'front' => 'required|string',
            'back' => 'required|string',
            'note' => 'nullable|string',
        ]);

        Vocabulary::updateOrCreate(
            ['id' => $this->vocabularyId],
            [
                'user_id' => auth()->id(),
                'front' => $this->front,
                'back' => $this->back,
                'note' => $this->note,
                'status' => 'unlearned',
            ]
        );

        $this->close();
        $this->emit('vocabularyAdded'); // 追加完了通知（親コンポーネントで受け取れる）
    }

    // モーダルを閉じる
    public function close()
    {
        $this->isOpen = false;
    }

}
