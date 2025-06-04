document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('rating-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const rating = form.querySelector('input[name="rating"]:checked')?.value;
        const comment = form.querySelector('textarea[name="comment"]').value.trim();

        if (!rating) {
            alert('Будь ласка, оберіть оцінку.');
            return;
        }

        const exhibitId = form.dataset.exhibitId;

        // Формуємо дані для відправки
        const data = new URLSearchParams();
        data.append('rating', rating);
        data.append('comment', comment);
fetch(`/MuseumShowcase/exhibits/rate/${exhibitId}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: data,
    credentials: 'same-origin'
})
.then(response => response.text()) // отримуємо відповідь як текст
.then(text => {
    console.log('Відповідь сервера:', text); // дивимось що прийшло
    try {
        const data = JSON.parse(text);
        // обробка JSON...
        const msgBlock = document.getElementById('rating-message');
        if (data.message) {
            msgBlock.style.color = 'green';
            msgBlock.textContent = data.message;
            form.reset();
        } else if (data.error) {
            msgBlock.style.color = 'red';
            msgBlock.textContent = data.error;
        }
    } catch (e) {
        console.error('Помилка парсингу JSON:', e);
    }
})
.catch(err => {
    console.error('Помилка при відправці:', err);
});
    });
});