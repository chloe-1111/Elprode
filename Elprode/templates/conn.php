<?php
    $conn = new PDO('sqlite:C:/xampp/htdocs/Elprode/templates/databaseelprode.db'); 
    if (!$conn) {
        die("Connection failed: " . $conn->errorInfo());
    }
?>

