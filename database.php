<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=pero_petrol', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
