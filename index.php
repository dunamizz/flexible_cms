<?php
require_once 'core/init.php';

$user = DB::getInstance()->query("SELECT username FROM users WHERE username = ?", array('Dunamis'));

if($user->error()) {
    echo 'No User';
} else {
    echo 'OK';
}