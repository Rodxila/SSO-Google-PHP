<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

if (!isset($_SESSION['access_token']) && isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
}


if (!isset($_SESSION['access_token']) || !isset($_SESSION['access_token']['access_token'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}


$client->setAccessToken($_SESSION['access_token']);
$oauth = new Google_Service_Oauth2($client);
$userInfo = $oauth->userinfo->get();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tu perfil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h1>Hola, <?php echo htmlspecialchars($userInfo->name); ?></h1>
        <p>Email: <?php echo htmlspecialchars($userInfo->email); ?></p>
        <a href="logout.php" class="button">Cerrar sesión</a>
    </div>
</body>
</html>
