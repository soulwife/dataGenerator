<?php
namespace Model;

/**
 * Description of SessionService
 *
 * @author Anastasiia
 */
class SessionService {
    
    public function __construct() {
        session_start();
    }
    
    public function saveToSession() {
        $dbHost = 'dbHost';
        $dbName = 'dbName';
        $dbUser = 'dbUser';
        $dbPass = 'dbPass';
        if (isset($_POST[$dbHost]) && isset($_POST[$dbName]) && isset($_POST[$dbUser]) && isset($_POST[$dbPass])) {
            $_SESSION[$dbHost] = $_POST[$dbHost];
            $_SESSION[$dbName] = $_POST[$dbName];
            $_SESSION[$dbUser] = $_POST[$dbUser];
            $_SESSION[$dbPass] = $_POST[$dbPass];
        }
    }
    
    function checkSession() {
        $status = session_status();
        if($status == PHP_SESSION_DISABLED) {
            echo "Please enable your session (turn off 'private mode', etc), because our tool workes with session";
        } elseif ($status == PHP_SESSION_NONE) {
            echo "Something wrong here. We are really sorry, can you please get back to index page and insert connection data?";
        } else {
           return 1;
        }
        return;
    }
}
