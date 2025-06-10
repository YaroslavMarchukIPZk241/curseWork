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
$(document).ready(function() {
    $('#searchInput').on('input', function() {
        var q = $(this).val();

        $.ajax({
            url: '/MuseumShowcase/admin/logs/search',
            data: { q: q },
            dataType: 'json',
            success: function(data) {
                var rows = '';
                data.forEach(function(log) {
                    rows += '<tr>' +
                        '<td>' + log.id + '</td>' +
                        '<td>' + log.user_id + '</td>' +
                        '<td>' + log.action + '</td>' +
                        '<td>' + log.ip_address + '</td>' +
                        '<td>' + log.created_at + '</td>' +
                        '<td>' + (log.method || '') + '</td>' +
                        '<td>' + (log.uri || '') + '</td>' +
                        '<td><button class="btn btn-primary btn-sm" onclick="alert(\'' + (log.message || '').replace(/'/g, "\\'") + '\')">Переглянути</button></td>' +
                    '</tr>';
                });
                $('#logsTableBody').html(rows);
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    fetch('/MuseumShowcase/admin/logs/stats')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.log_date);
            const counts = data.map(item => parseInt(item.count, 10));

            const ctx = document.getElementById('logsChart').getContext('2d');
            const logsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Кількість логів',
                        data: counts,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Дата'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Кількість'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Помилка завантаження статистики:', error));
});


fetch('/MuseumShowcase/admin/logs/statusStats')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.status_code),
                datasets: [{
                    label: 'Кількість по статус-кодах',
                    data: data.map(item => item.total),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                }]
            }
        });
    });
    fetch('/MuseumShowcase/admin/logs/userActivityStats')
    .then(res => res.json())
    .then(data => {
        new Chart(document.getElementById('userActivityChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.map(d => 'User #' + d.user_id),
                datasets: [{
                    label: 'Кількість дій',
                    data: data.map(d => d.total),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                }]
            }
        });
    });

    fetch('/MuseumShowcase/admin/logs/actionsStats')
    .then(res => res.json())
    .then(data => {
        new Chart(document.getElementById('actionChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.map(d => d.action),
                datasets: [{
                    label: 'Кількість',
                    data: data.map(d => d.total),
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                }]
            }
        });
    });
fetch('/MuseumShowcase/admin/logs/ipStats')
    .then(res => res.json())
    .then(data => {
        new Chart(document.getElementById('ipChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.map(d => d.ip_address),
                datasets: [{
                    label: 'Кількість',
                    data: data.map(d => d.total),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                }]
            }
        });
    });
fetch('/MuseumShowcase/admin/logs/methodStats')
    .then(res => res.json())
    .then(data => {
        new Chart(document.getElementById('methodChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: data.map(d => d.method),
                datasets: [{
                    data: data.map(d => d.total),
                    backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384', '#4BC0C0'],
                }]
            }
        });
    });
fetch('/MuseumShowcase/admin/logs/topUris')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('topUrisChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.uri),
                datasets: [{
                    label: 'Кількість звернень',
                    data: data.map(item => item.total),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Кількість звернень'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'URI'
                        }
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Помилка при завантаженні топ URI:', error);
    });
    
document.addEventListener('DOMContentLoaded', () => {
    const reviewsContainer = document.getElementById('reviews-container');
    const form = document.getElementById('review-form');
    const messageBlock = document.getElementById('review-message');
    let reviewsLoaded = false;
    let alreadyRated = false;

    const exhibitId = form?.dataset.exhibitId || reviewsContainer?.dataset.exhibitId;

    function formatDate(dateString) {
        const date = new Date(dateString);
        return `${date.toLocaleDateString()} ${date.toLocaleTimeString().slice(0, 5)}`;
    }

    // Завантаження відгуків
    fetch(`/MuseumShowcase/exhibits/getReviews/${exhibitId}`)
        .then(res => res.json())
        .then(data => {
            reviewsLoaded = true;

            if (!Array.isArray(data.reviews)) return;

            reviewsContainer.innerHTML = '';

            if (data.reviews.length === 0) {
                reviewsContainer.innerHTML = '<p>Поки що немає жодного відгуку. Будь першим!</p>';
            } else {
                data.reviews.forEach(review => {
                    const reviewCard = document.createElement('div');
                    reviewCard.className = 'review-card';
                    reviewCard.style = 'border:1px solid #ccc; padding:10px; margin-bottom:10px;';
                    reviewCard.innerHTML = `
                        <strong>${review.username}</strong>
                        <div>Оцінка: ${'⭐'.repeat(review.rating)} (${review.rating}/5)</div>
                        <p>${review.comment ? review.comment.replace(/\n/g, '<br>') : '<em>Без коментаря</em>'}</p>
                        <div style="font-size: 0.8em; color: #888;">${formatDate(review.created_at)}</div>
                    `;
                    reviewsContainer.appendChild(reviewCard);
                });
            }

            if (data.alreadyRated) {
                alreadyRated = true;
                form?.querySelectorAll('input, textarea, button').forEach(el => el.disabled = true);

                if (!document.getElementById('already-reviewed-note')) {
                    const alreadyMsg = document.createElement('p');
                    alreadyMsg.textContent = 'Ви вже залишали відгук.';
                    alreadyMsg.style = 'margin-top:10px; color: #555;';
                    alreadyMsg.id = 'already-reviewed-note';
                    form?.appendChild(alreadyMsg);
                }
            }
        })
        .catch(() => {
            reviewsContainer.innerHTML = '<p style="color:red;">Не вдалося завантажити відгуки.</p>';
        });

    // Обробка відправки форми
    form?.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!reviewsLoaded) {
            messageBlock.style.color = 'orange';
            messageBlock.textContent = 'Зачекайте, поки завантажаться відгуки...';
            return;
        }

        if (alreadyRated) {
            messageBlock.style.color = 'red';
            messageBlock.textContent = 'Ви вже залишали відгук.';
            return;
        }

        const rating = form.querySelector('input[name="rating"]:checked')?.value;
        const comment = form.querySelector('textarea[name="comment"]').value.trim();

        if (!rating) {
            messageBlock.style.color = 'red';
            messageBlock.textContent = 'Будь ласка, оберіть оцінку.';
            return;
        }

        const data = new URLSearchParams();
        data.append('rating', rating);
        data.append('comment', comment);

        fetch(`/MuseumShowcase/exhibits/rate/${exhibitId}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: data
        })
        .then(res => res.json())
        .then(data => {
            if (data.message) {
                messageBlock.style.color = 'green';
                messageBlock.textContent = data.message;
                form.reset();

                form.querySelectorAll('input, textarea, button').forEach(el => el.disabled = true);

                const newReview = document.createElement('div');
                newReview.className = 'review-card';
                newReview.style = 'border:1px solid #ccc; padding:10px; margin-bottom:10px;';
                newReview.innerHTML = `
                    <strong>${data.username}</strong>
                    <div>Оцінка: ${'⭐'.repeat(data.rating)} (${data.rating}/5)</div>
                    <p>${data.comment ? data.comment.replace(/\n/g, '<br>') : '<em>Без коментаря</em>'}</p>
                    <div style="font-size: 0.8em; color: #888;">${formatDate(data.created_at)}</div>
                `;
                reviewsContainer.prepend(newReview);

                alreadyRated = true;

                if (!document.getElementById('already-reviewed-note')) {
                    const alreadyMsg = document.createElement('p');
                    alreadyMsg.textContent = 'Ви вже залишали відгук.';
                    alreadyMsg.style = 'margin-top:10px; color: #555;';
                    alreadyMsg.id = 'already-reviewed-note';
                    form.appendChild(alreadyMsg);
                }
            } else if (data.error) {
                messageBlock.style.color = 'red';
                messageBlock.textContent = data.error;
            }
        })
        .catch(() => {
            messageBlock.style.color = 'red';
            messageBlock.textContent = 'Сталася помилка при надсиланні.';
        });
    });
});







/*                            */ 

document.addEventListener('DOMContentLoaded', () => {
  const filterForm = document.getElementById('filter-form');
  const exhibitContainer = document.getElementById('exhibit-container');

  async function loadExhibits(page = 1) {
    console.log('🔁 Початок завантаження експонатів...');

    const formData = new FormData(filterForm);
    formData.set('page', page); // додаємо сторінку

    const params = new URLSearchParams(formData);
    console.log('📦 Параметри форми:', Object.fromEntries(params.entries()));

    const pathParts = window.location.pathname.split('/');
    let periodId = pathParts[pathParts.length - 1];

    if (isNaN(periodId)) {
      periodId = pathParts[pathParts.length - 2]; // fallback
    }

    console.log('🆔 Отримано periodId:', periodId);

    const url = `/MuseumShowcase/period/exhibitList/${periodId}?${params.toString()}`;
    console.log('🌐 Виклик fetch за URL:', url);

    try {
      const response = await fetch(url);

      console.log('✅ Статус відповіді:', response.status);
      const text = await response.text();
      console.log('📄 Отриманий HTML (перші 300 символів):\n', text.substring(0, 300));

      if (!response.ok) {
        console.error('❌ Помилка відповіді від сервера:', response.statusText);
        exhibitContainer.innerHTML = '<p style="color:red;">Помилка завантаження експонатів</p>';
        return;
      }

      if (!text.trim()) {
        console.warn('⚠️ Отримано порожній HTML — можливо, нічого не знайдено або проблема у контролері');
        exhibitContainer.innerHTML = '<p style="color:orange;">Нічого не знайдено або сталася помилка</p>';
        return;
      }

      exhibitContainer.innerHTML = text;

      // Оновлюємо URL в адресному рядку без перезавантаження
      const newUrl = `${window.location.pathname}?${params.toString()}`;
      window.history.pushState({ path: newUrl }, '', newUrl);

      console.log('🔚 Завантаження завершено успішно.');
    } catch (error) {
      console.error('💥 Виняток при fetch:', error);
      exhibitContainer.innerHTML = '<p style="color:red;">Виникла помилка при завантаженні експонатів</p>';
    }
  }

  // Сабміт форми
  filterForm.addEventListener('submit', (e) => {
    e.preventDefault();
    console.log('📨 Форма надіслана');
    loadExhibits(1);
  });

  // Клік по пагінації
  exhibitContainer.addEventListener('click', (e) => {
    if (e.target.matches('.pagination a')) {
      e.preventDefault();
      const page = e.target.dataset.page;
      console.log('🔀 Перехід на сторінку:', page);
      if (page) {
        loadExhibits(page);
      }
    }
  });

  // Назад/вперед у браузері
  window.addEventListener('popstate', () => {
    console.log('🔙 Виклик popstate (назад/вперед)');
    loadExhibits();
  });
});







/*        квитки                        */


function openModal(title, description, originalPrice, discountedPrice, availableAt, promoCodeName, discountPercentage) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalDate').innerText = availableAt;
    document.getElementById('modalDescription').innerHTML = description;

    let priceHtml = '';
    let promoInfoHtml = '';

    if (promoCodeName && parseFloat(discountPercentage) > 0) {
        priceHtml = `<span style="text-decoration: line-through; color: #999;">${parseFloat(originalPrice).toFixed(2)}</span> <span style="color: green; font-weight: bold;">${parseFloat(discountedPrice).toFixed(2)}</span>`;
        promoInfoHtml = `Знижка за промокодом "${promoCodeName}" (${parseFloat(discountPercentage).toFixed(0)}%)`;
        document.getElementById('modalPromoInfo').style.display = 'block';
    } else {
        priceHtml = parseFloat(originalPrice).toFixed(2);
        document.getElementById('modalPromoInfo').style.display = 'none';
    }

    document.getElementById('modalPrice').innerHTML = priceHtml;
    document.getElementById('modalPromoInfo').innerText = promoInfoHtml;
    document.getElementById('ticketModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('ticketModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('ticketModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}