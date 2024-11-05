<?php
require 'vendor/autoload.php'; // Include Composer autoload

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); // Load the variables from the .env file

// Define constants for your API keys
define('XENDIT_API_KEY', getenv('XENDIT_API_KEY'));
