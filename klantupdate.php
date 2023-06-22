<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'databasshop';
    private $username = 'your_username';
    private $password = 'your_password';
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function updateCustomer($customerID, $newName, $newEmail, $newAddress, $newPostalCode, $newCity) {
        $query = "UPDATE KLANTEN SET klantnaam = :name, klantEmail = :email, klantAdres = :address, klantPostcode = :postal_code, klantWoonplaats = :city WHERE klantid = :customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':name', $newName);
        $stmt->bindValue(':email', $newEmail);
        $stmt->bindValue(':address', $newAddress);
        $stmt->bindValue(':postal_code', $newPostalCode);
        $stmt->bindValue(':city', $newCity);
        $stmt->bindValue(':customer_id', $customerID);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

class UpdateCustomerPage {
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerID = $_POST['customer_id'];
            $newName = $_POST['name'];
            $newEmail = $_POST['email'];
            $newAddress = $_POST['address'];
            $newPostalCode = $_POST['postal_code'];
            $newCity = $_POST['city'];

            $updated = $this->database->updateCustomer($customerID, $newName, $newEmail, $newAddress, $newPostalCode, $newCity);

            if ($updated) {
                echo "Customer updated successfully";
            } else {
                echo "Customer not found";
            }
        }
    }
}

$database = new Database();
$page = new UpdateCustomerPage($database);
$page->handleFormSubmission();
$database->closeConnection();
?>

<html>
<head>
    <title>Update Customer</title>
</head>
<body>
    <h2>Update Customer</h2>
    <form method="POST" action="update_customer.php">
        <label for="customer_id">Klant ID:</label>
        <input type="number" name="customer_id" id="customer_id" required>
        <br><br>
        <label for="name">Naam:</label>
        <input type="text" name="name" id="name" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br><br>
        <label for="address">adres:</label>
        <input type="text" name="address" id="address" required>
        <br><br>
        <label for="postal_code">Postcode:</label>
        <input type="text" name="postal_code" id="postal_code" required>
        <br><br>
        <label for="city">Stad:</label>
        <input type="text" name="city" id="city" required>
        <br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>

