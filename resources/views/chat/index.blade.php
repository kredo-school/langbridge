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
            </div>
            {{-- send messages area--}}
            <form id="chat-form" enctype="multipart/form-data">
                <input type="hidden" name="to_user_id" id="to_user_id"
                    value="{{ request('to_user_id') ?? ($users->first()->id ?? '') }}">
                <div class="mb-2" style="display:flex;align-items:center;gap:8px;">
                    {{-- upload pictures--}}
                    <label for="image"
                        style="cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:#e0e0e0;border-radius:50%;">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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

    <!-- Three-step report modal -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h4 class="modal-title">User Report</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <!-- Hidden: target message -->
                    <input type="hidden" id="report_message_id">


                    <!-- Step 1: Confirm -->
                    <div id="report-step-1">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                            <span id="report_user_avatar_wrapper">
                                <img id="report_user_avatar" src="" class="rounded-circle"
                                    style="width:40px;height:40px;object-fit:cover;display:none;">
                                <i id="report_user_icon" class="fas fa-user-circle"
                                    style="font-size:40px;color:#bbb;display:none;"></i>
                            </span>
                            <div>
                                <strong id="report_user_name" style="font-size:1.1em;"></strong><br>
                                <span id="report_user_handle" style="color:gray;font-size:0.9em;"></span>
                            </div>
                        </div>
                        <p>Are you sure you want to report this user?</p>
                    </div>

                    <!-- Step 2: Details -->
                    <div id="report-step-2" style="display:none;">
                        <div class="mb-3">
                            <div class="form-label mb-3 fw-bold">Please provide details</div>
                            <select id="report_reason" name="violation_reason_id" class="form-select" required>
                                <option value="" selected disabled>{{ __('Select a reason') }}</option>
                                @foreach($violationReasons as $reason)
                                <option value="{{ $reason->id }}">
                                    {{ app()->getLocale() === 'ja' ? $reason->name_JP : $reason->name_EN }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"></label>
                            <textarea id="report_details" name="detail" class="form-control" rows="3"
                                placeholder="Additional details (optional)"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Screenshot etc (optional)</label>
                            <input type="file" id="report_file" name="file" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <!-- Step 3: Submitted -->
                    <div id="report-step-3" style="display:none;">
                        <p class="fw-bold">Your report has been submitted.</p>
                        <p class="mt-1"> Thank you for your cooperation!</p>
                    </div>
                </div>

                <!-- Footer (dynamic buttons) -->
                <div class="modal-footer">
                    <!-- Step 1 buttons -->
                    <div id="report-footer-1">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="report-next-1">Next</button>
                    </div>

                    <!-- Step 2 buttons -->
                    <div id="report-footer-2" style="display:none;">
                        <button type="button" class="btn btn-secondary me-2" id="report-back-2">Back</button>
                        <button type="button" class="btn btn-danger" id="report-submit-2">Report</button>
                    </div>

                    <!-- Step 3 buttons -->
                    <div id="report-footer-3" style="display:none;">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- JavaScript for chat functionality --}}
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

        // always display sender's name
        let nameTag = msg.user_name;

        // flag icon (received messages only)
        let reportTag =
        msg.user_id != myId
        ? `<span style='cursor:pointer;color:#d32f2f;font-size:1.2em;' title='Report' onclick='openReportModal(${msg.id}, "${msg.user_name}", "${msg.partner_avatar ?? ''}", "${msg.partner_handle ?? ''}")'><i class="fa-solid fa-flag"></i></span>`
        : "";

        // delete button (only for own messages)
        let deleteBtn = "";
        if (msg.user_id == myId) {
            deleteBtn = `<button onclick="deleteMessage(${msg.id})" style="margin-left:8px;background:none; border:none;" class="btn btn-danger btn-sm">
           <i class="fas fa-trash-alt" style="color:#d32f2f;"></i></button>`;
        }

        // message display HTML (avatar and name left-aligned)
        box.innerHTML += [
            `<div style='text-align:${align};background:${bgColor};margin:5px 0;padding:5px;border-radius:8px;max-width:70%;display:inline-block;float:${align};clear:both;position:relative;'>`,
            `<div style="display:flex;align-items:center;justify-content:flex-start;gap:8px;">${avatarTag}<strong>${nameTag}</strong></div>`,
            ` ${msg.content} ${emojiTag}`,
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
    
    // open report modal and initialize steps
    function openReportModal(messageId, userName = '', userAvatar = '', userHandle = '') {
     document.getElementById('report_message_id').value = messageId;
     document.getElementById('report_user_name').textContent = userName;
     document.getElementById('report_user_handle').textContent = userHandle;

     const avatarImg = document.getElementById('report_user_avatar');
     const iconFallback = document.getElementById('report_user_icon');

  if (userAvatar && userAvatar.trim().length > 0) {
    avatarImg.src = userAvatar;
    avatarImg.style.display = 'inline-block';
    iconFallback.style.display = 'none';
  } else {
    avatarImg.style.display = 'none';
    iconFallback.style.display = 'inline-block';
  }

    // reset form fields and show step 1
    document.getElementById('report_reason').value = '';
    document.getElementById('report_details').value = '';
    document.getElementById('report_file').value = '';
    document.getElementById('report-step-1').style.display = 'block';
    document.getElementById('report-footer-1').style.display = 'flex';
    document.getElementById('report-step-2').style.display = 'none';
    document.getElementById('report-footer-2').style.display = 'none';
    document.getElementById('report-step-3').style.display = 'none';
    document.getElementById('report-footer-3').style.display = 'none';

    const modal = new bootstrap.Modal(document.getElementById('reportModal'));
    modal.show();
   }


    // close modal (for Bootstrap)
    function closeReportModal() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('reportModal'));
        if (modal) modal.hide();
    }

 
   // report modal step navigation
  document.addEventListener ('DOMContentLoaded', function () {
  const step1 = document.getElementById('report-step-1');
  const step2 = document.getElementById('report-step-2');
  const step3 = document.getElementById('report-step-3');

  const footer1 = document.getElementById('report-footer-1');
  const footer2 = document.getElementById('report-footer-2');
  const footer3 = document.getElementById('report-footer-3');

  document.getElementById('report-next-1').addEventListener('click', () => {
    step1.style.display = 'none';
    footer1.style.display = 'none';
    step2.style.display = 'block';
    footer2.style.display = 'flex';
  });

  document.getElementById('report-back-2').addEventListener('click', () => {
    step2.style.display = 'none';
    footer2.style.display = 'none';
    step1.style.display = 'block';
    footer1.style.display = 'flex';
  });

 document.getElementById('report-submit-2').addEventListener('click', () => {
  const messageId = document.getElementById('report_message_id').value;
  const reasonId = document.getElementById('report_reason').value; // ← ここ修正！
  const details = document.getElementById('report_details').value;
  const file = document.getElementById('report_file').files[0];

  if (!reasonId) {
    alert('Please select a reason for the report.');
    document.getElementById('report_reason').classList.add('is-invalid');
    return;
  } else {
    document.getElementById('report_reason').classList.remove('is-invalid');
  }

    const fd = new FormData();
    fd.append('violation_reason_id', reasonId);
    fd.append('detail', details);
    if (file) {
        fd.append('file', file);
    }
 

fetch(`/chat/report/${messageId}`, {
  method: 'POST',
  headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  body: fd,
   credentials: 'same-origin'
})
.then(async res => {
  if (!res.ok) {
    const errorData = await res.json();
    console.error('Validation error:', errorData);
    alert('報告に失敗しました: ' + (errorData.message || '不明なエラー'));
    throw new Error('Validation failed');
  }
  return res.json();
})
.then(data => {
  document.getElementById('report-step-2').style.display = 'none';
  document.getElementById('report-footer-2').style.display = 'none';
  document.getElementById('report-step-3').style.display = 'block';
  document.getElementById('report-footer-3').style.display = 'flex';
})
.catch(error => {
  console.error('❌ Report error:', error);
  alert('報告の送信中にエラーが発生しました');
});

 });
});
    </script>
    @endsection