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

// Обработчик AJAX для отправки в Telegram
add_action('wp_ajax_send_telegram_message', 'send_telegram_message');
add_action('wp_ajax_nopriv_send_telegram_message', 'send_telegram_message');

function send_telegram_message() {
    if (!defined('TELEGRAM_TOKEN') || !defined('TELEGRAM_CHAT_ID')) {
        wp_send_json_error(array('message' => 'Конфигурационные данные не настроены'));
        return;
    }

    $data = json_decode(stripslashes($_POST['data']), true); // Исправление декодирования JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        wp_send_json_error(array('message' => 'Ошибка декодирования данных: ' . json_last_error_msg()));
        return;
    }

    $token = TELEGRAM_TOKEN;
    $chat_id = TELEGRAM_CHAT_ID;

    $message = "Запрос обратной связи sve-toch.ru {$data['date_time']}:\n\n";
    $message .= "ФИО: {$data['full_name']}\n";
    $message .= "Телефон: {$data['phone']}\n";
    $message .= "E-mail: {$data['email']}\n\n";
    $message .= "Сообщение: {$data['message']}\n";

    error_log('Отправка в Telegram: ' . $message); // Отладка

    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $response = wp_remote_post($url, array(
        'body' => array(
            'chat_id' => $chat_id,
            'text' => $message
        )
    ));

    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => 'Ошибка при отправке в Telegram: ' . $response->get_error_message()));
    } else {
        wp_send_json_success();
    }
    wp_die();
}