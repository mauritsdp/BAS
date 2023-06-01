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
       
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function insertCustomer($klantnaam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats)
    {
       
        $sql = "INSERT INTO KLANTEN (klantnaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $klantnaam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function closeConnection()
    {
        
        $this->conn->close();
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $klantnaam = $_POST["klantnaam"];
    $klantEmail = $_POST["klantEmail"];
    $klantAdres = $_POST["klantAdres"];
    $klantPostcode = $_POST["klantPostcode"];
    $klantWoonplaats = $_POST["klantWoonplaats"];

    
    $db = new Database();

   
    if ($db->insertCustomer($klantnaam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats)) {
        echo "New customer added successfully.";
    } else {
        echo "Error adding customer.";
    }

    
    $db->closeConnection();
}
?>

>
<!DOCTYPE html>
<html>
<head>
    <title>Klant Toevoegen</title>
</head>
<body>
    <h2>Klant toevoegen</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="klantnaam">Klant naam:</label>
        <input type="text" name="klantnaam" required><br><br>

        <label for="klantEmail">Email:</label>
        <input type="email" name="klantEmail" required><br><br>

        <label for="klantAdres">Adres:</label>
        <input type="text" name="klantAdres" required><
