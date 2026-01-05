<?php
header('Content-Type: application/json');

// --- ඔබේ පැනල් විස්තර ---
$panel_url = "http://kalpika.netrox.site:2025/netro"; 
$panel_user = "kalpika1";
$panel_pass = "kalpika2"; 
// -----------------------

$email = $_GET['email'] ?? '';
if (!$email) {
    echo json_encode(['success' => false, 'msg' => 'Username required']);
    exit;
}

$cookie_file = tempnam(sys_get_temp_dir(), 'cookie');
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);

// 1. Login
curl_setopt($ch, CURLOPT_URL, $panel_url . "/login");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['username' => $panel_user, 'password' => $panel_pass]));
curl_exec($ch);

// 2. Get Data
curl_setopt($ch, CURLOPT_URL, $panel_url . "/xui/API/inbounds/getClientTraffics/" . urlencode($email));
curl_setopt($ch, CURLOPT_POST, 0);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
if (file_exists($cookie_file)) unlink($cookie_file);
?>