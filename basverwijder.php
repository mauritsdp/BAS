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

    public function deleteCustomer($customerID) {
        $query = "DELETE FROM KLANTEN WHERE klantid = :customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':customer_id', $customerID);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerID = $_POST['customer_id'];

    $database = new Database();
    $deleted = $database->deleteCustomer($customerID);

    if ($deleted) {
        echo "Klant verwijdert";
    } else {
        echo "Klant Niet gevonden";
    }

    $database->closeConnection();
}
?>

<html>
<head>
    <title>Verwijder klant</title>
</head>
<body>
    <h2>Klant verwijderen</h2>
    <form method="POST" action="delete_customer.php">
        <label for="customer_id">Customer ID:</label>
        <input type="number" name="customer_id" id="customer_id" required>
        <br><br>
        <input type="submit" value="Delete">
    </form>
</body>
</html>

