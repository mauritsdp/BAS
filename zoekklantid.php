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

    public function getCustomerByID($customerID) {
        $query = "SELECT * FROM KLANTEN WHERE klantid = :customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':customer_id', $customerID);
        $stmt->execute();

        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        return $customer;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerID = $_POST['customer_id'];

    $database = new Database();
    $customer = $database->getCustomerByID($customerID);

    if ($customer) {
        echo "Customer ID: " . $customer['klantid'] . "<br>";
        echo "Name: " . $customer['klantnaam'] . "<br>";
        echo "Email: " . $customer['klantEmail'] . "<br>";
        echo "Address: " . $customer['klantAdres'] . "<br>";
        echo "Postal Code: " . $customer['klantPostcode'] . "<br>";
        echo "City: " . $customer['klantWoonplaats'] . "<br>";
    } else {
        echo "Customer not found";
    }

    $database->closeConnection();
}
?>

<html>
<head>
    <title>Zoek klant</title>
</head>
<body>
    <h2>Zoek klant</h2>
    <form method="POST" action="search_customer.php">
        <label for="customer_id">Klant ID:</label>
        <input type="number" name="customer_id" id="customer_id" required>
        <br><br>
        <input type="submit" value="Search">
    </form>
</body>
</html>
-
