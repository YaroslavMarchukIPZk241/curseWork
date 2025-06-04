<h1>Квитки на вхід</h1>
<div class="ticket-container">
    <?php foreach ($tickets as $ticket): ?>
        <div class="ticket"
             onclick="openModal(
                 `<?= htmlspecialchars($ticket->title) ?>`,
                 `<?= nl2br(htmlspecialchars($ticket->description)) ?>`,
                 `<?= htmlspecialchars($ticket->price) ?>`,
                 `<?= htmlspecialchars($ticket->available_at) ?>`
             )">
            <h3><?= htmlspecialchars($ticket->title) ?></h3>
            <p><strong>Ціна:</strong> <?= htmlspecialchars($ticket->price) ?> грн</p>
            <p><em>Доступно з:</em> <?= htmlspecialchars($ticket->available_at) ?></p>
        </div>
    <?php endforeach; ?>
</div>



<div id="ticketModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle"></h2>
        <p><strong>Ціна:</strong> <span id="modalPrice"></span> грн</p>
        <p><em>Доступно з:</em> <span id="modalDate"></span></p>
        <p id="modalDescription"></p>
    </div>
</div>

<script>
function openModal(title, description, price, availableAt) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalPrice').innerText = price;
    document.getElementById('modalDate').innerText = availableAt;
    document.getElementById('modalDescription').innerHTML = description;
    document.getElementById('ticketModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('ticketModal').style.display = 'none';
}

// Закриття при кліку поза модальним вікном
window.onclick = function(event) {
    const modal = document.getElementById('ticketModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
</script>

<style>
.ticket {
    border: none;
    padding: 20px;
    width: 260px;
    min-height: 180px;
    cursor: pointer;
    background: linear-gradient(135deg, #f0f8ff, #d1e8ff);
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.ticket:hover {
    transform: scale(1.03);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    background: linear-gradient(135deg, #e0f0ff, #a6d8ff);
}
.ticket h3 {
    margin-top: 0;
    font-size: 1.2rem;
    color: #003366;
}
.ticket p {
    margin: 5px 0;
    font-size: 0.95rem;
    color: #333;
}
.ticket-container {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    justify-content: center;
    margin-top: 20px;
}
/* Модальне вікно */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 0 15px rgba(0,0,0,0.3);
    position: relative;
}

.close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 24px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
}
.close:hover {
    color: red;
}
</style>
