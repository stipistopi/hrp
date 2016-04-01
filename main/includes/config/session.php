<?php
function storeNewAuthToken($userId) {
    $selector = base64_encode(openssl_random_pseudo_bytes(9));
    $authenticator = openssl_random_pseudo_bytes(33);

    setcookie(
        'remember', // name
        $selector . ':' . base64_encode($authenticator), // value
        time() + (86400 * 14), // expire
        '/', // path
        'hrp-interaktiv.hu', // domain
        false, // secure
        true  // httponly
    );

    $token = hash('sha256', $authenticator);
    $expires = date('Y-m-d\TH:i:s', time() + (86400 * 14));

    global $conn;

    $stmt = $conn->prepare("DELETE FROM auth_tokens
                            WHERE userid = :userid");
    $stmt->bindParam(':userid', $userId);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO auth_tokens (selector, token, userid, expires)
                            VALUES (:selector, :token, :userid, :expires)");
    $stmt->bindParam(':selector', $selector);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':userid', $userId);
    $stmt->bindParam(':expires', $expires);
    $stmt->execute();

    $_SESSION['auth_token'] = $token;
}

function deleteAuthToken($token) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM auth_tokens
                            WHERE token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
}

if (!isset($_SESSION)) session_start();

if (empty($_SESSION['is_auth']) && !empty($_COOKIE['remember'])) {
    list($selector, $authenticator) = explode(':', $_COOKIE['remember']);

    $stmt = $conn->prepare("SELECT token, userid
                            FROM auth_tokens
                            WHERE selector = :selector");
    $stmt->bindParam(':selector', $selector);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_BOTH);

    $userId = $result['userid'];
    $authToken = $result['token'];

    if (hash_equals($authToken, hash('sha256', base64_decode($authenticator)))) {
        storeNewAuthToken($userId);
        $_SESSION['is_auth'] = true;
    }
}
