<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Settings for Lekirpay for WooCommerce.
 */
return array(
    'enabled' => array(
        'title' => __('Enable/Disable', 'lrw'),
        'type' => 'checkbox',
        'label' => __('Enable Lekirpay', 'lrw'),
        'default' => 'yes'
    ),
    'title' => array(
        'title' => __('Title', 'lrw'),
        'type' => 'text',
        'description' => __('This controls the title which the user sees during checkout.', 'lrw'),
        'default' => __('Lekirpay (Online Banking)', 'lrw')
    ),
    'description' => array(
        'title' => __('Description', 'lrw'),
        'type' => 'textarea',
        'description' => __('This controls the description which the user sees during checkout.', 'lrw'),
        'default' => __('', 'lrw')
    ),
    'client_id' => array(
        'title' => __('Client ID', 'lrw'),
        'type' => 'text',
        'placeholder' => 'Example : 23546345',
        'description' => __('Please enter your Lekirpay Client ID. ', 'lrw') . ' ' . sprintf(__('<br/> Login to Lekirpay >> Go to the top right of the menu >> Click profile button >> Navigate to API tab', 'lrw'), '', ''),
        'default' => ''
    ),
    'client_secret' => array(
        'title' => __('Lekirkey', 'lrw'),
        'type' => 'text',
        'placeholder' => 'Example : df23hjhlv234ug2i53vv32423hj86kjg4k89jasd',
        'description' => __('Please enter your Lekirkey.', 'lrw') . ' ' . sprintf(__('<br/> Login to Lekirpay >> Go to the top right of the menu >> Click profile button >> Navigate to API tab', 'lrw'), '', ''),
        'default' => ''
    ),
	'lekir_signature' => array(
        'title' => __('Lekir-signature Key', 'lrw'),
        'type' => 'text',
        'placeholder' => 'Optional',
        'description' => __('', 'lrw') . ' ' . sprintf(__('', 'lrw'), '', ''),
        'default' => '',
		'desc_tip' => 'Enable this will redirect to secure payment page',
    ),
	'group_id' => array(
        'title' => __('Group ID', 'lrw'),
        'type' => 'text',
        'placeholder' => 'Optional',
        'description' => __('', 'lrw') . ' ' . sprintf(__('','lrw'), '', ''),
        'default' => '',
		'desc_tip' => 'Added to default group if group_id is not present',
    ),
    'clearcart' => array(
        'title' => __('Clear Cart Session', 'lrw'),
        'type' => 'checkbox',
        'label' => __('Tick to clear cart session on checkout', 'lrw'),
        'default' => 'no'
    ),
    'debug' => array(
        'title' => __('Debug Log', 'lrw'),
        'type' => 'checkbox',
        'label' => __('Enable logging', 'lrw'),
        'default' => 'no',
        'description' => sprintf(__('Log Lekirpay events, such as IPN requests, inside <code>%s</code>', 'lrw'), wc_get_log_file_path('Lekirpay'))
    ),
    'instructions' => array(
        'title' => __('Instructions', 'lrw'),
        'type' => 'textarea',
        'description' => __('Instructions that will be added to the thank you page and emails.', 'lrw'),
        'default' => '',
        'desc_tip' => true,
    ),
    'custom_error' => array(
        'title' => __('Error Message', 'lrw'),
        'type' => 'text',
        'placeholder' => 'Example : You have cancelled the payment. Please make a payment!',
        'description' => __('Error message that will appear when customer cancel the payment.', 'lrw'),
        'default' => 'You have cancelled the payment. Please make a payment!'
    ),
    'checkout_label' => array(
        'title' => __('Checkout Label', 'lrw'),
        'type' => 'text',
        'placeholder' => 'Example: Pay with Lekirpay',
        'description' => __('Button label on checkout.', 'lrw'),
        'default' => 'Pay with Lekirpay'
    ),
    'sandbox' => array(
        'title' => __('Sandbox Server', 'lrw'),
        'type' => 'checkbox',
        'label' => __('Enable Sandbox Server, disable will set to default Live Server', 'lrw'),
        'default' => 'no',
        'desc_tip' => 'Live : https://app.Lekirpay.com  <br> Sandbox : http://sandbox.Lekirpay.com',
    ),
    'payment_paid_status' => array(
        'title' => __('Select your status after a successful payment', 'lrw'),
        'type' => 'select',
        'description' => __('This controls the status after successful payment.', 'lrw'),
        'default' => 'completed',
        'options' => array(
            'processing' => __('Processing', 'lrw'),
            'on-hold' => __('On Hold', 'lrw'),
            'completed' => __('Completed', 'lrw'),
        ),
    ),

);
