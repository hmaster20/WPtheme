<footer>
    <div class="footer-content">
        <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Все права защищены.', 'careerpro'); ?>
        <br>
        <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php _e('Политика конфиденциальности', 'careerpro'); ?></a></p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>