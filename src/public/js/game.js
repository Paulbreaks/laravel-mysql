let betInput = document.getElementById('bet');
let playButton = document.querySelector('#game-form button[type="submit"]'); // Кнопка "Играть"
let balanceText = document.getElementById('balance'); // Баланс

// ✅ Колесо мыши для изменения ставки
betInput.addEventListener('wheel', function (event) {
    event.preventDefault();
    let currentValue = parseInt(this.value) || 10;
    if (event.deltaY < 0) {
        this.value = currentValue * 10; // Увеличиваем
    } else if (event.deltaY > 0) {
        this.value = Math.max(10, currentValue / 10); // Уменьшаем
    }
});

// ✅ Обработка отправки формы
document.getElementById('game-form').addEventListener('submit', function (event) {
    event.preventDefault();

    let bet = parseFloat(betInput.value);
    let slotResult = document.getElementById('slot-result');
    let gameResults = document.getElementById('game-results');
    let payoutText = document.getElementById('game-payout').querySelector('span');
    let balanceText = document.getElementById('balance');
    let currencyText = document.getElementById('currency');
    let currentBalance = parseFloat(balanceText.textContent.replace(/[^\d.-]/g, ''));
    let betError = document.getElementById('bet-error'); //Получаем блок ошибки

    // ✅ Проверяем баланс перед ставкой
    if (bet > currentBalance) {
        betError.style.display = "block"; // Показываем сообщение об ошибке
        return;
    } else {
        betError.style.display = "none"; // Скрываем ошибку, если всё норм
    }

    // 🔹 Отключаем кнопку "Играть" на время вращения
    playButton.disabled = true;

    // 🔹 Мгновенно списываем ставку с баланса
    balanceText.textContent = (currentBalance - bet).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") // ✅ Убираем валюту, так как она уже есть в `currencyText`

    // 🔄 Сбрасываем всё перед запуском
    slotResult.textContent = "— — —";
    gameResults.style.display = "none";

    fetch(window.Laravel.gamePlayUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": window.Laravel.csrfToken // Берём CSRF токен
        },
        body: JSON.stringify({ bet: bet })
    })

        .then(response => response.json())
        .then(data => {
            console.log("Ответ сервера:", data);

            if (data.error) {
                alert(data.error);
                playButton.disabled = false;
                return;
            }

            let finalNumbers = data.result.split(""); // Реальные цифры из ответа сервера
            let animationTime = 20; // Интервал смены чисел
            let slotNumbers = ["?", "?", "?"];

            // 🎰 Запускаем вращение всех цифр
            let slotAnimation = setInterval(() => {
                slotResult.textContent =
                    `${slotNumbers[0] === "?" ? Math.floor(Math.random() * 10) : slotNumbers[0]} ` +
                    `${slotNumbers[1] === "?" ? Math.floor(Math.random() * 10) : slotNumbers[1]} ` +
                    `${slotNumbers[2] === "?" ? Math.floor(Math.random() * 10) : slotNumbers[2]}`;
            }, animationTime);

            // ⏳ Останавливаем цифры по очереди
            setTimeout(() => {
                slotNumbers[0] = finalNumbers[0];
            }, 1000);
            setTimeout(() => {
                slotNumbers[1] = finalNumbers[1];
            }, 2000);
            setTimeout(() => {
                slotNumbers[2] = finalNumbers[2];
                clearInterval(slotAnimation);
                slotResult.textContent = slotNumbers.join(" ");

                // 🎉 Показываем выигрыш после остановки всех цифр
                setTimeout(() => {
                    gameResults.style.display = "block";
                    payoutText.textContent = parseFloat(data.payout).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    // 🔹 Если выигрыш > 0, показываем зелёный текст, если 0 — красный
                    payoutText.style.color = (data.payout > 0) ? "green" : "red";

                    // ✅ Обновляем баланс после выигрыша
                    balanceText.textContent = parseFloat(data.balance).toLocaleString(
                        'en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }
                    );

                    // ✅ Включаем кнопку обратно после завершения игры
                    playButton.disabled = false;
                }, 500);
            }, 3000);
        })
        .catch(error => {
            console.error("Ошибка запроса:", error);
            playButton.disabled = false;
        });
});