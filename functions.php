<?php
/**
 * CareerPro Theme Functions
 */

function careerpro_setup() {
    // Поддержка заголовков
    add_theme_support('title-tag');
    
    // Поддержка логотипа
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
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
}

add_action('after_setup_theme', 'careerpro_setup');

function careerpro_enqueue_styles() {
    wp_enqueue_style('careerpro-style', get_stylesheet_uri(), array(), '1.1');
    // Убрано подключение Google Fonts для производительности
}

add_action('wp_enqueue_scripts', 'careerpro_enqueue_styles');
?>