<?php
/*
Plugin Name: Custom Site Functions
Description: Custom Wordpress functions intended to be used with ACF. By Matthew de Marillac.
Version: 1.0.0
*/

if (!defined('ABSPATH')) {
    exit;
}

if (!wp_next_scheduled('custom_site_email_debug_log')) {
    wp_schedule_event(time(), 'daily', 'custom_site_email_debug_log');
}

add_action('woocommerce_before_checkout_form', function () {

    if (!function_exists('get_field')) {
        return;
    }

    $settings_page_id = 66313;

    if (!get_field('holiday_notice_enabled', $settings_page_id)) {
        return;
    }

    $startDate  = get_field('holiday_start_date', $settings_page_id);
    $returnDate = get_field('holiday_return_date', $settings_page_id);

    if (!$startDate || !$returnDate) {
        return;
    }

    $start = DateTime::createFromFormat('d/m/Y', $startDate);
    $return = DateTime::createFromFormat('d/m/Y', $returnDate);

    if (!$start || !$return) {
        return;
    }

    // Dates are date not datetime so ensure mindnight is always set to 0.
    $start->setTime(0, 0, 0);
    $return->setTime(0, 0, 0);

    // Use the site's timezone.
    $today = new DateTime('today', wp_timezone());
    // Only show the notice while we're away.
    if ($today < $start || $today > $return) {
        return;
    }


    $holiday_notice_text = get_field('holiday_notice', $settings_page_id);

    if (!$holiday_notice_text) {
        return;
    }

    wc_print_notice(
        sprintf(
            $holiday_notice_text,
            esc_html($return->format(get_option('date_format')))
        ),
        'error'
    );

});

/**
 * Email the debug log once per day if it has changed.
 */
add_action('custom_site_email_debug_log', function () {

    $settings_page_id = 66313;

    if (!function_exists('get_field')) {
        return;
    }

    if (!get_field('email_debug_log_enabled', $settings_page_id)) {
        return;
    }

    $recipient = get_field('email_debug_log_address', $settings_page_id);

    if (empty($recipient)) {
        $recipient = get_option('admin_email');
    }

    $log = WP_CONTENT_DIR . '/debug.log';

    if (!file_exists($log) || filesize($log) === 0) {
        return;
    }

    $hash = md5_file($log);

    $last_hash = get_option('custom_site_last_debug_log_hash');

    if ($hash === $last_hash) {
        return;
    }

    $sent = wp_mail(
        $recipient,
        '[' . get_bloginfo('name') . '] Debug Log',
        'The attached WordPress debug log has changed.',
        [],
        [$log]
    );

    if ($sent) {
        update_option('custom_site_last_debug_log_hash', $hash);
    }

});