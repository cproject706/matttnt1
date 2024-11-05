<?php
require 'vendor/autoload.php'; // Include the Composer autoload file
require 'config.php'; // Include your config file

// Set the API key directly in the Payments class
\Xendit\Xendit::setApiKey(XENDIT_API_KEY); // Set the API key directly

// Create a GCash payment request
function createGcashPayment($external_id, $amount) {
    try {
        $params = [
            'external_id' => $external_id,
            'amount' => $amount,
            'currency' => 'PHP', // Currency code for the payment
            'payment_method' => [
                'type' => 'gcash', // Specify GCash as the payment method
            ],
        ];

        // Create the payment using the Payments class
        $response = \Xendit\Payments::create($params);
        return $response;
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}

// Example usage
$external_id = uniqid('payment_'); // Unique identifier for the payment
$amount = 100; // Amount in PHP (e.g., 100 PHP)

$paymentResponse = createGcashPayment($external_id, $amount);
echo '<pre>';
print_r($paymentResponse);
echo '</pre>';
