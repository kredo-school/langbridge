@extends('layouts.app')

{{-- chat screen main template --}}
@section('content')
<div class="container w-75">
    <div style="display:flex;gap:24px;">
        {{-- left side: chat partner selection form --}}
        <div style="width:220px;min-width:180px;">
            <h5>Chat Partner</h5>
            <form id="user-select-form" method="GET" action="/chat">
                <div class="mb-2">
                    <label>Select Chat Partner:</label>
                    <div style="max-height:320px;overflow-y:auto;">
                        @foreach($users as $user)
                        <button type="submit" name="to_user_id" value="{{ $user->id }}" class="btn btn-light w-100 mb-2"
                            style="display:flex;align-items:center;gap:10px;padding:6px 10px;text-align:left;">
                            @if($user->profile && $user->profile->avatar)
                            <img src="{{ $user->profile->avatar }}" class="rounded-circle"
                                style="width:32px;height:32px;object-fit:cover;">
                            @else
                            <i class="fas fa-user-circle" style="font-size:32px;color:#bbb;"></i>
                            @endif
                            <span>{{ $user->name }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
        {{-- right side: chat main body --}}
        <div style="flex:1;">
            {{-- chat room title --}}
            <h3>Chat Room</h3>
            {{-- display message area --}}
            <div id="chat-box"
                style="height:400px;overflow-y:scroll;border:1px solid #ccc;padding:10px;margin-bottom:10px;">

                {{-- message send area--}}
                <form id="chat-form" enctype="multipart/form-data">
                    <input type="text" name="to_user_id" id="to_user_id" value="{{ request('to_user_id') ?? ($users->first()->id ?? '') }}">
                    <div class="mb-2" style="display:flex;align-items:center;gap:8px;">
                        {{-- upload pictures plus Icon（gray circle +） --}}
                        <label for="image"
                            style="cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:#e0e0e0;border-radius:50%;">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="9" y="4" width="2" height="12" rx="1" fill="#333" />
                                <rect x="4" y="9" width="12" height="2" rx="1" fill="#333" />
                            </svg>
                        </label>
                        <input type="file" name="image" id="image" class="form-control" style="display:none;">
                        {{-- message＋emoji＋send button input area（emoji and send button on the right end） --}}
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
        function fetchMessages(to_user_id){
        return fetch(`/chat/fetch?to_user_id=${to_user_id}`)
            .then(res => res.json())
    }

    function deleteMessage(messageId) {
        if (!confirm('Do you want to delete this message?')) return;
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
        // image tag
        let imgTag = (msg.image_path && msg.image_path !== 'null' && msg.image_path.length > 0)
            ? `<img src='${msg.image_path}' style='max-width:100px;'>`
            : "";

        // emoji tag
        let emojiTag = msg.emoji ? msg.emoji : "";
        // read/unread display
        let readTag = msg.is_read
            ? '<span style="color:gray;">(Read)</span>'
            : '<span style="color:gray;">(Unread)</span>';

        // time tag
        let timeTag = msg.sent_at
            ? `<span style='color:gray;font-size:0.9em;'>${msg.sent_at}</span>`
            : "";

        // alignment, background color, and name
        let align = msg.user_id == myId ? "right" : "left";
        let bgColor = msg.user_id == myId ? "#e0f7fa" : "#f1f8e9";

        let avatarTag;
        if (msg.user_id == myId) {
            avatarTag = msg.user_avatar != null && msg.user_avatar?.length > 0
                ? `<img src='${msg.user_avatar}' class="rounded-circle" style="width:32px;height:32px;">`
                : `<i class="fas fa-user-circle" style="font-size:32px;color:#bbb;"></i>`;
        } else {
            avatarTag = msg.partner_avatar != null && msg.partner_avatar?.length > 0
                ? `<img src='${msg.partner_avatar}' class="rounded-circle" style="width:32px;height:32px;">`
                : `<i class="fas fa-user-circle" style="font-size:32px;color:#bbb;"></i>`;
        }

        console.debug(avatarTag);

        // always display sender's name
        let nameTag = msg.user_name;

        // flag icon (received messages only)
        let reportTag =
            msg.user_id != myId
            ? `<span style='cursor:pointer;color:#d32f2f;font-size:1.2em;cursor:pointer;' title='Report' onclick='openReportModal(${msg.id})'><i class="fa-solid fa-flag"></i></span>`
            : "";


        // delete button (only for own messages)
        let deleteBtn = "";
        if (msg.user_id == myId) {
            deleteBtn = `<button onclick="deleteMessage(${msg.id})" style="margin-left:8px;" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>`;
        }

        // message display HTML (delete button next to flag icon)
        box.innerHTML += [
            `<div style='text-align:${align};background:${bgColor};`,
            `margin:5px 0;padding:5px;border-radius:8px;max-width:70%;display:inline-block;float:${align};clear:both;position:relative;'>`,
            avatarTag,
            `<strong>${nameTag}</strong>: ${msg.content} ${emojiTag}`,
            imgTag ? `<div style='margin-top:4px;'>${imgTag}</div>` : "",
            `<div style='margin-top:4px;font-size:0.9em;'>${timeTag} ${readTag}</div>`,
            reportTag,
            deleteBtn,
            `</div><div style='clear:both;'></div>`,
        ].join("");
    }

    // function to fetch and display message list
    function displayMessages() {
        // get selected user ID
        const to_user_id = document.getElementById('to_user_id')?.value || document.getElementById('form_to_user_id')?.value;
        if (!to_user_id) return;

        // fetch message list from server
        fetchMessages(to_user_id)
            .then(data =>{
                const box = document.getElementById('chat-box');
                box.innerHTML = '';
                const myId = {{ auth()->id() }};
                // display each fetched message
                data.messages.forEach(msg => {
                    formatMessage(msg, box, myId);
                });
                box.scrollTop = box.scrollHeight;
            });
    }

    // message delete process
    displayMessages();
    setInterval(displayMessages, 5000);

    // message send process
    const form = document.getElementById('chat-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        // send message to server

        const fd = new FormData(form);
        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: fd
        })
        .then(res => res.json())
        .then(() => {
            // reset form after sending and fetch latest messages
            form.reset();
            document.getElementById('content').value = '';
            document.getElementById('emoji').value = '';
            document.getElementById('image').value = '';
            fetchMessages();
        });
    });

    // show modal
    function openReportModal(messageId) {
        document.getElementById('report_message_id').value = messageId;
            document.getElementById('report_title').value = '';
            document.getElementById('report_date').value = '';
            document.getElementById('report_description').value = '';
            document.getElementById('report_image').value = '';
        var modal = new bootstrap.Modal(document.getElementById('reportModal'));
        modal.show();
    }

    // close modal (for Bootstrap)
    function closeReportModal() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('reportModal'));
        if (modal) modal.hide();
    }

   // show modal on flag icon click
   // example: <span onclick="openReportModal(${msg.id})">...</span>

   // report submission
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const fd = new FormData(form);
        const messageId = document.getElementById('report_message_id').value;
        fetch(`/chat/report/${messageId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: fd
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            closeReportModal();
        });
    });
  
    </script>

    @endsection


    <!-- 報告モーダル（Bootstrap公式構造） -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Stream Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="reportForm">
                    <div class="modal-body">
                        <input type="hidden" name="message_id" id="report_message_id">
                        <label for="report_title">Title</label>
                        <input type="text" name="report_title" id="report_title" class="form-control" required>
                        <input type="hidden" name="message_id" id="report_message_id">
                        <label for="report_date">Date</label>
                        <input type="date" name="report_date" id="report_date" class="form-control" required>
                        <input type="hidden" name="message_id" id="report_message_id">
                        <label for="report_description">Description</label>
                        <textarea name="report_description" id="report_description" class="form-control" rows="3"
                            required></textarea>
                        <input type="hidden" name="message_id" id="report_message_id">
                        <label for="report_image">Image (optional)</label>
                        <input type="file" name="report_image" id="report_image" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Report</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>