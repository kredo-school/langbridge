document.addEventListener('DOMContentLoaded', () => {
    // Blade から渡されるグローバル変数
    const questions = window.quizData.questions;
    const side = window.quizData.side;

    let currentIndex = 0;

    const card = document.getElementById('card');
    const btnShow = document.getElementById('show-answer');
    const btnNext = document.getElementById('next-question');

    renderQuestion();

    function renderQuestion() {
        const q = questions[currentIndex];

        if (side === "front") {
            card.textContent = q.front;
        } else {
            card.textContent = q.back;
        }
    }

    btnShow.addEventListener('click', () => {
        const q = questions[currentIndex];
        if (side === "front") {
            card.textContent = q.back;
        } else {
            card.textContent = q.front;
        }
    });

    btnNext.addEventListener('click', () => {
        currentIndex++;

        if (currentIndex >= questions.length) {
            card.textContent = "Completed!";
            btnShow.disabled = true;
            btnNext.disabled = true;
            return;
        }
        renderQuestion();
    });
});

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
