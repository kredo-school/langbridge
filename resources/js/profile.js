
            let isTranslated = false;
        
            document.getElementById('translate-btn').addEventListener('click', function () {
                const resultDiv = document.getElementById('translation-result');
        
                if (isTranslated) {
                    
                    resultDiv.innerHTML = '';
                    isTranslated = false;
                } else {
                    
                    const text = document.getElementById('bio-text').innerText;
        
                    fetch("/translate ", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
    