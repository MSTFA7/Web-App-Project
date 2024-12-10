<?php
// Load environment variables (use a library like vlucas/phpdotenv or directly define constants)
$access_key = "0648db71-4110-4ffa-b013-027614a239e3"; // Replace this with an environment variable in production

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$issue = $_POST['issue'] ?? '';

// Validate input (basic example)
if (empty($name) || empty($email) || empty($issue)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input or bot detected."]);
    exit;
}

// Prepare data for Web3Forms
$data = [
    'access_key' => $access_key,
    'name' => $name,
    'email' => $email,
    'issue' => $issue,
];
// Send the data using cURL
$url = "https://api.web3forms.com/submit";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);
curl_close($ch);
header('Location: ../pages/submitted.html');


?>
