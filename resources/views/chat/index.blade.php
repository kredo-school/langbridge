@extends('layouts.app')

{{-- チャット画面のメインテンプレート --}}
@section('content')
<div class="container w-75">
    <div style="display:flex;gap:24px;">
        {{-- 左側：対話相手の選択フォーム --}}
        <div style="width:220px;min-width:180px;">
            <h5>Chat Partner</h5>
            <form id="user-select-form" method="GET" action="/chat">
                <div class="mb-2">
                    <label>Select Chat Partner:</label>
                    <select name="to_user_id" id="to_user_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Please select</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ (request('to_user_id')==$user->id) ? 'selected' : '' }}>{{
                            $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        {{-- 右側：チャット本体 --}}
        <div style="flex:1;">
            {{-- チャットルームのタイトル --}}
            <h3>Chat Room</h3>
            {{-- メッセージ表示エリア --}}
            <div id="chat-box"
                style="height:400px;overflow-y:scroll;border:1px solid #ccc;padding:10px;margin-bottom:10px;">
                <!-- 報告モーダル -->
                <div class="modal" id="reportModal" tabindex="-1"
                    style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);z-index:9999;align-items:center;justify-content:center;">
                    <div style="background:#fff;padding:20px;border-radius:8px;max-width:400px;margin:auto;">
                        <h5>Report Message</h5>
                        <form id="reportForm">
                            <input type="hidden" name="message_id" id="report_message_id">
                            <div class="mb-2">
                                <label for="report_content">Report Content:</label>
                                <textarea name="report_content" id="report_content" class="form-control" rows="3"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Report</button>
                            <button type="button" class="btn btn-secondary" onclick="closeReportModal()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- メッセージ送信フォーム --}}
            <form id="chat-form" enctype="multipart/form-data">
                <input type="hidden" name="to_user_id" id="form_to_user_id" value="{{ request('to_user_id') }}">
                <div class="mb-2" style="display:flex;align-items:center;gap:8px;">
                    {{-- 画像アップロード用Plusアイコン（灰色円＋） --}}
                    <label for="image"
                        style="cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:#e0e0e0;border-radius:50%;">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="9" y="4" width="2" height="12" rx="1" fill="#333" />
                            <rect x="4" y="9" width="12" height="2" rx="1" fill="#333" />
                        </svg>
                    </label>
                    <input type="file" name="image" id="image" class="form-control" style="display:none;">
                    {{-- メッセージ＋絵文字＋送信ボタン入力欄（右端に絵文字と送信ボタン） --}}
                    <div style="display:flex;flex:1;position:relative;align-items:center;">
                        <input type="text" name="content" id="content" class="form-control"
                            placeholder="Enter your message" style="width:100%;padding-right:96px;">
                        <input list="emojis" name="emoji" id="emoji" class="form-control" placeholder="😊"
                            style="position:absolute;right:48px;top:0;width:40px;height:100%;border:none;background:transparent;">
                        <datalist id="emojis">
                            <option value="😀">😀</option>
                            <option value="😂">😂</option>
                            <option value="😊">😊</option>
                            <option value="😍">😍</option>
                            <option value="👍">👍</option>
                            <option value="🙏">🙏</option>
                            <option value="🎉">🎉</option>
                            <option value="🥺">🥺</option>
                            <option value="😎">😎</option>
                            <option value="😭">😭</option>
                        </datalist>
                        <button type="submit" class="btn btn-primary"
                            style="position:absolute;right:0;top:0;width:40px;min-width:40px;height:100%;padding:0;display:flex;align-items:center;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path d="M2 21L23 12L2 3V10L17 12L2 14V21Z" fill="#fff" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // 報告モーダルを表示する関数
    function openReportModal(messageId) {
        document.getElementById('report_message_id').value = messageId;
        document.getElementById('report_content').value = '';
        document.getElementById('reportModal').style.display = 'flex';
    }
    // 報告モーダルを閉じる関数
    function closeReportModal() {
        document.getElementById('reportModal').style.display = 'none';
    }

    function fetchMessages(to_user_id){
        return fetch(`/chat/fetch?to_user_id=${to_user_id}`)
            .then(res => res.json())
    }

    function deleteMessage(messageId) {
        if (!confirm('このメッセージを削除しますか？')) return;
        fetch(`/chat/delete/${messageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(() => {
            displayMessages();
        });
    }

    function formatMessage(msg, box, myId) {
        // 画像タグ
        let imgTag = msg.image_path
            ? `<img src='${msg.image_path}' style='max-width:100px;'>`
            : "";
        // 絵文字タグ
        let emojiTag = msg.emoji ? msg.emoji : "";
        // 既読・未読表示
        let readTag = msg.is_read
            ? '<span style="color:gray;">(既読)</span>'
            : '<span style="color:gray;">(未読)</span>';

        // 日時タグ
        let timeTag = msg.sent_at
            ? `<span style='color:gray;font-size:0.9em;'>${msg.sent_at}</span>`
            : "";
        // 右左・背景色・名前
        let align = msg.user_id == myId ? "right" : "left";
        let bgColor = msg.user_id == myId ? "#e0f7fa" : "#f1f8e9";
        let nameTag = msg.user_id == myId ? "My Name" : "Partner Name";

        // 旗アイコン（受信メッセージのみ）
        let reportTag =
            msg.user_id != myId
            ? ` <span style='cursor:pointer;color:#d32f2f;font-size:1.2em;' title='報告する' onclick='openReportModal(${msg.id})'>🚩</span>`
            : "";

        // 削除ボタン（自分のメッセージのみ）
        let deleteBtn = "";
        if (msg.user_id == myId) {
            deleteBtn = `<button onclick="deleteMessage(${msg.id})" style="margin-left:8px;" class="btn btn-danger btn-sm">削除</button>`;
        }

        // メッセージ表示HTML（旗アイコンの隣に削除ボタン）
        box.innerHTML += [
            `<div style='text-align:${align};background:${bgColor};`,
            `margin:5px 0;padding:5px;border-radius:8px;max-width:70%;display:inline-block;float:${align};clear:both;position:relative;'>`,
            `<strong>${nameTag}</strong>: ${msg.content} ${emojiTag}`,
            imgTag ? `<div style='margin-top:4px;'>${imgTag}</div>` : "",
            `<div style='margin-top:4px;font-size:0.9em;'>${timeTag} ${readTag}</div>`,
            reportTag,
            deleteBtn,
            `</div><div style='clear:both;'></div>`,
        ].join("");
    }

    // メッセージ一覧を取得して表示する関数
    function displayMessages() {
        // 選択中のユーザーIDを取得
        const to_user_id = document.getElementById('to_user_id')?.value || document.getElementById('form_to_user_id')?.value;
        if (!to_user_id) return;

        // サーバーからメッセージ一覧を取得
        fetchMessages(to_user_id)
            .then(data =>{
                const box = document.getElementById('chat-box');
                box.innerHTML = '';
                const myId = {{ auth()->id() }};
                // 取得したメッセージを1件ずつ表示
                data.messages.forEach(msg => {
                    formatMessage(msg, box, myId);
                });
                box.scrollTop = box.scrollHeight;
            });
    }

    // メッセージ削除処理
    displayMessages();
    setInterval(displayMessages, 5000);

    // メッセージ送信処理
    const form = document.getElementById('chat-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        // 入力内容をFormDataで取得
        const fd = new FormData(form);
        fd.set('to_user_id', document.getElementById('to_user_id')?.value || document.getElementById('form_to_user_id')?.value);
        // 絵文字欄の値も明示的にセット
        fd.set('emoji', document.getElementById('emoji').value || '');
        // サーバーにメッセージ送信
        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: fd
        })
        .then(res => res.json())
        .then(() => {
            // 送信後フォームをリセットし、最新メッセージ取得
            form.reset();
            document.getElementById('content').value = '';
            document.getElementById('emoji').value = '';
            document.getElementById('image').value = '';
            fetchMessages();
        });
    });

    // 報告送信処理
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // 報告内容をFormDataで取得
        const fd = new FormData(this);
        // サーバーに報告内容を送信
        fetch('/chat/report', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: fd
        })
        .then(res => res.json())
        .then(data => {
            // 報告送信後、モーダルを閉じて通知
            alert('報告が送信されました');
            closeReportModal();
        });
    });
</script>

@endsection