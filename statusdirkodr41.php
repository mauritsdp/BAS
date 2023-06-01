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
            
            // Set error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getSalesOrders()
    {
        try {
          
            $sql = "SELECT * FROM VERKOOPORDERS";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        } catch (PDOException $e) {
            echo "Error retrieving sales orders: " . $e->getMessage();
            return false;
        }
    }

    public function closeConnection()
    {
       
        $this->conn = null;
    }
}


$db = new Database();


$salesOrders = $db->getSalesOrders();


$db->closeConnection();

?>


<!DOCTYPE html>
<html>
<head>
    <title>Verkoop Orders</title>
</head>
<body>
    <h2>Verkoop Orders</h2>
    <table>
        <tr>
            <th>Verkoop ID</th>
            <th>Klant ID</th>
            <th>Art ID</th>
            <th>Verkoop aantal</th>
            <th>Status</th>
        </tr>
        <?php foreach ($salesOrders as $order) { ?>
            <tr>
                <td><?php echo $order['verkOrdId']; ?></td>
                <td><?php echo $order['klantId']; ?></td>
                <td><?php echo $order['artId']; ?></td>
                <td><?php echo $order['verkOrdBestAantal']; ?></td>
                <td><?php echo $order['verkOrdStatus']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
