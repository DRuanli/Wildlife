<?php
// Resources/views/auth/logout.php

// Ensure user is authenticated before logout
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to login page with logout confirmation
header("Location: /login?logout=success");
exit();
?>