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
        <form>
            <div class="form-group">
                <input type="text" placeholder="Ваше имя" required>
            </div>
            <div class="form-group">
                <textarea placeholder="Ваше сообщение" required></textarea>
            </div>
            <button type="submit">Отправить</button>
        </form>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>