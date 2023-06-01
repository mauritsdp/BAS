<?php

class Database
{
    private $servername = "localhost"; 
    private $username = "maurits"; 
    private $password = "maurits"; 
    private $dbname = "databasshop"; 
    private $conn;

    public function __construct()
    {
        try {
            
            $dsn = "mysql:host={$this->servername};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
          
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function createSalesOrder($klantId, $artId, $verkOrdBestAantal)
    {
        try {
            
            $sql = "INSERT INTO VERKOOPORDERS (klantId, artId, verkOrdBestAantal, verkOrdStatus)
                    VALUES (?, ?, ?, 1)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$klantId, $artId, $verkOrdBestAantal]);
            
            return true;
        } catch (PDOException $e) {
            echo "Error creating sales order: " . $e->getMessage();
            return false;
        }
    }

    public function closeConnection()
    {
       
        $this->conn = null;
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $klantId = $_POST["klantId"];
    $artId = $_POST["artId"];
    $verkOrdBestAantal = $_POST["verkOrdBestAantal"];

   
    $db = new Database();

  
    if ($db->createSalesOrder($klantId, $artId, $verkOrdBestAantal)) {
        echo "Sales order created successfully.";
    } else {
        echo "Error creating sales order.";
    }

    
    $db->closeConnection();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Verkoop order aanmaken</title>
</head>
<body>
    <h2>Verkoop order aanmaken</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="klantId">Klant ID:</label>
        <input type="number" name="klantId" required><br><br>

        <label for="artId">Product ID:</label>
        <input type="number" name="artId" required><br><br>

        <label for="verkOrdBestAantal">Order Groote:</label>
        <input type="number" name="verkOrdBestAantal" required><br><br>

        <input type="submit" value="Create Sales Order">
    </form>
</body>
</html>
