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

    $data = json_decode(stripslashes($_POST['data']), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        wp_send_json_error(array('message' => 'Ошибка декодирования данных: ' . json_last_error_msg()));
        return;
    }

    // Серверная валидация > в дополнение к footer.php > function submitChatForm(event)
    // Серверная валидация необходима, чтобы защитить от поддельных запросов и гарантировать, что данные 
    // соответствуют требованиям, даже если клиентская валидация (JavaScript) отключена или обойдена.
    $fullName = sanitize_text_field($data['full_name']);
    $phone = sanitize_text_field($data['phone']);
    $email = sanitize_email($data['email']);
    $message = sanitize_textarea_field($data['message']);

    $nameParts = explode(' ', $fullName);
    if (count($nameParts) < 2 || array_filter($nameParts, fn($part) => !preg_match('/^[a-zA-Zа-яА-ЯёЁ]{2,}$/', $part))) {
        wp_send_json_error(array('message' => 'ФИО должно содержать минимум два слова без цифр, каждое не менее 2 символов.'));
        return;
    }
    if (!preg_match('/^\+?\d{10,15}$/', $phone)) {
        wp_send_json_error(array('message' => 'Номер телефона должен содержать 10-15 цифр (например, +7123456789).'));
        return;
    }
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Введите корректный email.'));
        return;
    }

    $token = TELEGRAM_TOKEN;
    $chat_id = TELEGRAM_CHAT_ID;

    $messageText = "Запрос обратной связи sve-toch.ru {$data['date_time']}:\n\n";
    $messageText .= "ФИО: {$fullName}\n";
    $messageText .= "Телефон: {$phone}\n";
    $messageText .= "E-mail: {$email}\n\n";
    $messageText .= "Сообщение: {$message}\n";

    error_log('Отправка в Telegram: ' . $messageText); // Отладка

    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $response = wp_remote_post($url, array(
        'body' => array(
            'chat_id' => $chat_id,
            'text' => $messageText
        )
    ));

    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => 'Ошибка при отправке в Telegram: ' . $response->get_error_message()));
    } else {
        wp_send_json_success();
    }
    wp_die();
}