<?php
// Set CORS headers to allow requests from local testing and the main domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get the raw POST data
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!$data) {
    // If not JSON, try reading normal POST parameters
    $data = $_POST;
}

if (empty($data)) {
    echo "Error: Empty request data";
    exit;
}

$to = "info@powerlinedxb.com";
$from = "info@powerlinedxb.com";
$subject = $data['Subject'] ?? 'New website lead';
$body = $data['Body'] ?? '';

if (empty($body)) {
    echo "Error: Email body is empty";
    exit;
}

// HTML email headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: " . $from . "\r\n";
$headers .= "Reply-To: " . $from . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send the email using PHP's native mail function
if (mail($to, $subject, $body, $headers)) {
    echo "OK";
} else {
    echo "Error: PHP mail function failed to send the email. Please check your server's mail configuration.";
}
?>
