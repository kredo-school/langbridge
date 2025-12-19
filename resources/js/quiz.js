document.addEventListener("DOMContentLoaded", () => {

    const showAnswerBtn = document.getElementById("show-answer-btn");
    const answerText = document.getElementById("answer-text");
    const selfCheck = document.getElementById("self-check");

    if (showAnswerBtn) {
        showAnswerBtn.addEventListener("click", () => {
            
            answerText.classList.remove("d-none");

            
            selfCheck.classList.remove("d-none");

            
            showAnswerBtn.disabled = true;
            showAnswerBtn.classList.add("disabled");
        });
    }
});
