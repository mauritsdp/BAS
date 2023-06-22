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

    public function updateArticle($articleID, $newDescription, $newPurchasePrice, $newSalePrice, $newStock, $newMinStock, $newMaxStock) {
        $query = "UPDATE ARTIKELEN SET artOmschrijving = :description, artInkoop = :purchase_price, artVerkoop = :sale_price, artVoorraad = :stock, artMinVoorraad = :min_stock, artMaxVoorraad = :max_stock WHERE artId = :article_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':description', $newDescription);
        $stmt->bindValue(':purchase_price', $newPurchasePrice);
        $stmt->bindValue(':sale_price', $newSalePrice);
        $stmt->bindValue(':stock', $newStock);
        $stmt->bindValue(':min_stock', $newMinStock);
        $stmt->bindValue(':max_stock', $newMaxStock);
        $stmt->bindValue(':article_id', $articleID);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

class UpdateArticlePage {
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleID = $_POST['article_id'];
            $newDescription = $_POST['description'];
            $newPurchasePrice = $_POST['purchase_price'];
            $newSalePrice = $_POST['sale_price'];
            $newStock = $_POST['stock'];
            $newMinStock = $_POST['min_stock'];
            $newMaxStock = $_POST['max_stock'];

            $updated = $this->database->updateArticle($articleID, $newDescription, $newPurchasePrice, $newSalePrice, $newStock, $newMinStock, $newMaxStock);

            if ($updated) {
                echo "Article updated successfully";
            } else {
                echo "Article not found";
            }
        }
    }
}

$database = new Database();
$page = new UpdateArticlePage($database);
$page->handleFormSubmission();
$database->closeConnection();
?>


<html>
<head>
    <title>Update Article</title>
</head>
<body>
    <h2>Update Article</h2>
    <form method="POST" action="update_article.php">
        <label for="article_id">Artikel ID:</label>
        <input type="number" name="article_id" id="article_id" required>
        <br><br>
        <label for="description">Beschijving:</label>
        <input type="text" name="description" id="description" required>
        <br><br>
        <label for="purchase_price">Koop prijs:</label>
        <input type="number" name="purchase_price" id="purchase_price" required>
        <br><br>
        <label for="sale_price">Verkoop prijs:</label>
        <input type="number" name="sale_price" id="sale_price" required>
        <br><br>
        <label for="stock">Voorraad:</label>
        <input type="number" name="stock" id="stock" required>
        <br><br>
        <label for="min_stock">Min voorraad:</label>
        <input type="number" name="min_stock" id="min_stock" required>
        <br><br>
        <label for="max_stock">Max voorraad:</label>
        <input type="number" name="max_stock" id="max_stock" required>
        <br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
