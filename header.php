<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php wp_head(); ?>
    <style>
        .site-logo {
            max-width: 80px;
            height: auto;
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="site-header">
            <div class="site-title">
                <?php
                if (function_exists('the_custom_logo') && has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . esc_url(home_url('/')) . '"><img src="' . get_template_directory_uri() . '/images/logo.png" alt="' . get_bloginfo('name') . '" class="site-logo"></a>';
                }
                ?>
            </div>
            <button class="nav-toggle" aria-label="Toggle navigation">☰</button>
            <div class="contact-info">
                <a href="tel:+1234567890">+1 234 567 890</a>
                <a href="https://wa.me/1234567890" class="whatsapp"><i class="fab fa-whatsapp"></i></a>
                <a href="https://t.me/username" class="telegram"><i class="fab fa-telegram-plane"></i></a>
            </div>
        </div>
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'primary-menu',
                'container' => false,
            ));
            ?>
        </nav>
    </header>
    <script>
        document.querySelector('.nav-toggle').addEventListener('click', () => {
            document.querySelector('.main-navigation').classList.toggle('active');
        });
    </script>
</body>
</html>