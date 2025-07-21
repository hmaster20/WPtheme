<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        .site-logo {
            max-width: 100px;
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
            <nav class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'primary-menu',
                    'container' => false,
                ));
                ?>
            </nav>
        </div>
    </header>
    <script>
        document.querySelector('.nav-toggle').addEventListener('click', () => {
            document.querySelector('.main-navigation').classList.toggle('active');
        });
    </script>
</body>
</html>