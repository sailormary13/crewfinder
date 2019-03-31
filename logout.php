<?php
    // if user logged in ==> delete session vars to log them out
    session_start();
    if (isset($_SESSION['user_id'])) {
        // delete session vars by clearing $_SESSION array
        $_SESSION = array();
        
        // delete the sesion cookie by setting exp. date to an hour ago
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600);
        }
        
        // destory the session
        session_destroy();
    }
    
    // delete the user ID and username cookies
    setcookie('user_id', '', time() - 3600);
    setcookie('username', '', time() - 3600);
    
    
    // redirect to home page
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/crewfinder.php';
    header('Location: ' . $home_url);
    
?>