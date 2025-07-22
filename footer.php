<footer>
    <div class="footer-content">
        <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Все права защищены.', 'careerpro'); ?> <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php _e('Политика конфиденциальности', 'careerpro'); ?></a></p>
    </div>
    <!-- Чат кнопка -->
    <button class="chat-button" onclick="toggleChatPopup()">💬</button>
    <!-- Всплывающая форма чата -->
    <div class="chat-popup" id="chatPopup">
        <button class="close-btn" onclick="toggleChatPopup()">×</button>
        <h3>Обратная связь</h3>
        <form id="chatForm" onsubmit="return submitChatForm(event)">
            <div class="form-group">
                <input type="text" name="full_name" placeholder="Ваше ФИО" required>
            </div>
            <div class="form-group">
                <input type="tel" name="phone" placeholder="Ваш номер телефона" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Ваш E-mail" required>
            </div>
            <div class="form-group">
                <textarea name="message" placeholder="Ваше сообщение"></textarea>
            </div>
            <button type="submit">Отправить</button>
            <div id="formMessage" class="form-message"></div>
        </form>
    </div>
    <!-- JavaScript для переключения попапа и отправки формы -->
    <script>
        function toggleChatPopup() {
            const chatPopup = document.getElementById('chatPopup');
            chatPopup.classList.toggle('active');
        }

        function submitChatForm(event) {
            event.preventDefault();
            const form = document.getElementById('chatForm');
            const formData = new FormData(form);
            const messageDiv = document.getElementById('formMessage');

            // Валидация
            const fullName = formData.get('full_name').trim();
            const phone = formData.get('phone').trim();
            const email = formData.get('email').trim();
            const nameParts = fullName.split(' ');
            if (nameParts.length < 2 || nameParts.some(part => !/^[a-zA-Zа-яА-ЯёЁ]{2,}$/.test(part))) {
                messageDiv.textContent = 'ФИО должно содержать минимум два слова без цифр, каждое не менее 2 символов.';
                messageDiv.style.color = 'red';
                return false;
            }
            if (!/^\+?\d{10,15}$/.test(phone)) {
                messageDiv.textContent = 'Номер телефона должен содержать 10-15 цифр (например, +1234567890).';
                messageDiv.style.color = 'red';
                return false;
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                messageDiv.textContent = 'Введите корректный email.';
                messageDiv.style.color = 'red';
                return false;
            }

            // Данные для отправки
            const data = {
                full_name: fullName,
                phone: phone,
                email: email,
                message: formData.get('message') || 'Нет сообщения',
                date_time: new Date().toLocaleString('ru-RU', { timeZone: 'Europe/Berlin' }),
                user_agent: navigator.userAgent
            };

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=send_telegram_message&data=' + encodeURIComponent(JSON.stringify(data))
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    messageDiv.textContent = 'Сообщение успешно отправлено!';
                    messageDiv.style.color = 'green';
                    form.reset();
                    setTimeout(() => {
                        toggleChatPopup();
                        messageDiv.textContent = '';
                    }, 2000);
                } else {
                    messageDiv.textContent = 'Ошибка отправки: ' + result.message;
                    messageDiv.style.color = 'red';
                }
            })
            .catch(error => {
                messageDiv.textContent = 'Произошла ошибка: ' + error.message;
                messageDiv.style.color = 'red';
            });

            return false;
        }
    </script>
</footer>
<?php wp_footer(); ?>
</body>
</html>