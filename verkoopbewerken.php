<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'your_database_name';
    private $username = 'your_username';
    private $password = 'your_password';
    private $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo 'Connection failed: ' . $exception->getMessage();
        }

        return $this->conn;
    }
}

class SalesOrder
{
    private $conn;
    private $table_name = 'sales_orders';

    public $sales_order_id;
    public $customer_id;
    public $product_id;
    public $quantity;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET customer_id = :customer_id, product_id = :product_id, quantity = :quantity WHERE sales_order_id = :sales_order_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':customer_id', $this->customer_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':sales_order_id', $this->sales_order_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

$database = new Database();
$db = $database->getConnection();

$sales_order = new SalesOrder($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sales_order->sales_order_id = $_POST['sales_order_id'];
    $sales_order->customer_id = $_POST['customer_id'];
    $sales_order->product_id = $_POST['product_id'];
    $sales_order->quantity = $_POST['quantity'];

    if ($sales_order->update()) {
        echo 'Sales Order updated successfully.';
    } else {
        echo 'Unable to update Sales Order.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Verkoop Order</title>
</head>
<body>
    <h2>Update verkoop Order</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="sales_order_id">verkoop Order ID:</label>
        <input type="number" name="sales_order_id" id="sales_order_id" required>
        <br><br>
        <label for="customer_id">Klant ID:</label>
        <input type="number" name="customer_id" id="customer_id" required>
        <br><br>
        <label for="product_id">Product ID:</label>
        <input type="number" name="product_id" id="product_id" required>
        <br><br>
        <label for="quantity">Hoeveelheid:</label>
        <input type="number" name="quantity" id="quantity" required>
        <br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
