<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $supplier = $_POST['supplier'];
    $article = $_POST['article'];
    $quantity = $_POST['quantity'];

 
    $servername = "localhost";
    $username = "maurits";
    $password = "maurits";
    $dbname = "databasshop";

    try {
    
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        $query = "INSERT INTO INKOOPORDERS (levId, artId, inkOrdBestAantal) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$supplier, $article, $quantity]);

        echo
