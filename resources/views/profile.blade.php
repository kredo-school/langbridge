@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profile</h2>
    <div class="card p-4">
        <div class="mb-3">
            <strong>Nickname:</strong> {{ $profile->nickname }}
        </div>
        <div class="mb-3">
            <strong>Handle:</strong> {{ $profile->handle }}
        </div>
        <div class="mb-3">
            <strong>Age:</strong> {{ $user->age }}
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <label class="form-label mb-0">Bio</label>
            <button id="translate-btn" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-language"></i>
            </button>
        </div>
               
        <p id="bio-text">{{ $profile->bio }}</p>

        <div id="translation-result" class="mt-2"></div>

        <script>
            let isTranslated = false;
        
            document.getElementById('translate-btn').addEventListener('click', function () {
                const resultDiv = document.getElementById('translation-result');
        
                if (isTranslated) {
                    
                    resultDiv.innerHTML = '';
                    isTranslated = false;
                } else {
                    
                    const text = document.getElementById('bio-text').innerText;
        
                    fetch("{{ route('translate') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ text: text })
                    })
                    .then(response => response.json())
                    .then(data => {
                        resultDiv.innerHTML =
                            `<p><strong>Original:</strong> ${data.original}</p>
                             <p><strong>Translation:</strong> ${data.translated}</p>`;
                        isTranslated = true;
                    })
                    .catch(error => console.error("Error:", error));
                }
            });
        </script>
        <div class="mb-3">
            <strong>Japanese Level:</strong> {{ $profile->JP_level }}
        </div>
        <div class="mb-3">
            <strong>English Level:</strong> {{ $profile->EN_level }}
        </div>
        <div class="mb-3">
            <strong>Country:</strong> {{ $profile->user->country }}
        </div>
        <div class="mb-3">
            <strong>Region:</strong> {{ $profile->user->region }}
        </div>
        <div class="mb-3">
            <strong>interest:</strong>
            @foreach ($profile->user->interests as $interest)
                <span class="badge bg-primary">{{ $interest->name }}</span>
            @endforeach
        </div>
        @if (auth()->id() === $profile->user_id)
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Edit</a>
        @endif
    </div>
</div>
@endsection

