<?php
require 'vendor/autoload.php'; // Load the Xendit PHP SDK

use Xendit\Xendit;

Xendit::setApiKey('xnd_production_WaPtv4RQlder89kyAtK0brJnmtTZ4HtLlziAYy1VxDHuOwHtQmoU4OdlcUI3d');

$input = json_decode(file_get_contents('php://input'), true);
$tokenId = $input['tokenId'];

try {
    $charge = \Xendit\Card::create([
        'token_id' => $tokenId,
        'external_id' => 'booking_' . time(), // Unique ID for the transaction
        'amount' => 5000 // Replace with the actual amount
    ]);

    if ($charge['status'] === 'CAPTURED') {
        // Payment successful
        echo json_encode(['success' => true]);
    } else {
        // Payment failed
        echo json_encode(['success' => false]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
