<?php
function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
?>
