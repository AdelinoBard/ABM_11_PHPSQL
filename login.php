<?php // login.php
  $host = 'localhost';      // Change as necessary
  $db   = 'publications';   // Change as necessary
  $user = 'abm';            // Change as necessary
  $pass = 'password';       // Change as necessary
  $chrs = 'utf8mb4';
  $attr = "mysql:host=$host;dbname=$db;charset=$chrs";
  $opts =
  [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];
?>