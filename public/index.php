<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();

// Helper to reliably read env vars (checks $_ENV, $_SERVER, then getenv)
if (!function_exists('env_var')) {
    function env_var(string $key)
    {
        if (array_key_exists($key, $_ENV) && $_ENV[$key] !== null) {
            return $_ENV[$key];
        }
        if (array_key_exists($key, $_SERVER) && $_SERVER[$key] !== null) {
            return $_SERVER[$key];
        }
        $v = getenv($key);
        return ($v === false) ? null : $v;
    }
}

$client = new Google_Client(); // ← Aquí se crea
$clientId = env_var('GOOGLE_CLIENT_ID');
$clientSecret = env_var('GOOGLE_CLIENT_SECRET');
$redirect = env_var('GOOGLE_REDIRECT_URI') ?? 'http://localhost:9778/callback.php';

if (!$clientId || !is_string($clientId)) {
    throw new RuntimeException('GOOGLE_CLIENT_ID is not set. Check your .env and that php-dotenv loaded it.');
}
if (!$clientSecret || !is_string($clientSecret)) {
    throw new RuntimeException('GOOGLE_CLIENT_SECRET is not set. Check your .env and that php-dotenv loaded it.');
}

$client->setClientId((string)$clientId);
$client->setClientSecret((string)$clientSecret);
$client->setRedirectUri((string)$redirect);
$client->addScope("email");
$client->addScope("profile");

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    header('location: callback.php');
    exit;
}

$loginUrl = $client->createAuthUrl();
// Debug helper: show client info when ?debug=1 is present
if (isset($_GET['debug']) && $_GET['debug']) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "GOOGLE_CLIENT_ID: " . ($client->getClientId() ?? '(null)') . "\n";
    echo "GOOGLE_REDIRECT_URI: " . ($redirect ?? '(null)') . "\n";
    echo "Auth URL: " . $loginUrl . "\n";
    exit;
}



?>
<!DOCTYPE html>
<html>
<head>
    <title>Login con Google</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h1>Bienvenido</h1>
        <p>Accede con tu cuenta de Google para continuar</p>
        <a href="<?php echo $loginUrl; ?>" class="button">Iniciar sesión con Google</a>
    </div>
</body>
</html>

