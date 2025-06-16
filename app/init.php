<?php
require_once __DIR__ . "/../DB_connection.php";
require_once __DIR__ . "/Model/Task.php";

require_once __DIR__ . "/Model/User.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

