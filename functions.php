<?php
/**
 * CareerPro Theme Functions
 */

function careerpro_setup() {
    // Поддержка заголовков
    add_theme_support('title-tag');
    
    // Поддержка логотипа
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 80,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Поддержка меню
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'careerpro'),
    ));
    
    // Поддержка стилей редактора
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    // Поддержка favicon
    add_theme_support('custom-header', array(
        'default-image' => get_template_directory_uri() . '/images/favicon.ico',
    ));
}

add_action('after_setup_theme', 'careerpro_setup');

function careerpro_enqueue_styles() {
    // Подключение Google Fonts
    wp_enqueue_style('careerpro-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap', array(), null);
    wp_enqueue_style('careerpro-style', get_stylesheet_uri(), array('careerpro-google-fonts'), '1.2');
}

add_action('wp_enqueue_scripts', 'careerpro_enqueue_styles');
?>