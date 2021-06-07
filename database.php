<?php
// If connection is established
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=pero_petrol', 'root', '');
// If there is error in connection
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
