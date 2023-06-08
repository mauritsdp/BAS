<!DOCTYPE html>
<html>
<head>
    <title>Maak verkoop order aan</title>
</head>
<body>
    <h2>Koop order</h2>
    <form method="POST" action="create_purchase_order.php">
        <label for="supplier">Supplier:</label>
        <select name="supplier" id="supplier">
            <?php
            
            $servername = "localhost";
            $username = "maurits";
            $password = "maurits";
            $dbname = "databasshop";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               
                $query = "SELECT * FROM LEVERANCIERS";
                $stmt = $conn->prepare($query);
                $stmt->execute();

                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['levid']}'>{$row['levnaam']}</option>";
                }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            ?>
        </select>
        <br><br>
        <label for="article">Article:</label>
        <select name="article" id="article">
            <?php
           
            $query = "SELECT * FROM ARTIKELEN";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['artId']}'>{$row['artOmschrijving']}</option>";
            }

          
            $conn = null;
            ?>
        </select>
        <br><br>
        <label for="quantity">Hoeveelheid:</label>
        <input type="number" name="quantity" id="quantity" required>
        <br><br>
        <input type="submit" value="Create Order">
    </form>
</body>
</html>
