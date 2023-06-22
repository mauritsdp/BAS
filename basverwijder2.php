<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'databasshop';
    private $username = '';
    private $password = '';
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function deletePurchaseOrder($orderID) {
        $query = "DELETE FROM INKOOPORDERS WHERE inkOrdId = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':order_id', $orderID);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function deleteSalesOrder($orderID) {
        $query = "DELETE FROM VERKOOPORDERS WHERE verkOrdId = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':order_id', $orderID);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

class DeleteOrderPage {
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderID = $_POST['order_id'];
            $orderType = $_POST['order_type'];

            if ($orderType === 'purchase') {
                $deleted = $this->database->deletePurchaseOrder($orderID);
            } elseif ($orderType === 'sales') {
                $deleted = $this->database->deleteSalesOrder($orderID);
            }

            if ($deleted) {
                echo "Order deleted successfully";
            } else {
                echo "Order not found";
            }
        }
    }
}

$database = new Database();
$page = new DeleteOrderPage($database);
$page->handleFormSubmission();
$database->closeConnection();
?>

<html>
<head>
    <title>Verwijder order</title>
</head>
<body>
    <h2>Verwijder order</h2>
    <form method="POST" action="delete_order.php">
        <label for="order_id">Order ID:</label>
        <input type="number" name="order_id" id="order_id" required>
        <br><br>
        <label for="order_type">Order Type:</label>
        <select name="order_type" id="order_type" required>
            <option value="purchase">Koop order</option>
            <option value="sales">verkoop Order</option>
        </select>
        <br><br>
        <input type="submit" value="Delete">
    </form>
</body>
</html>
