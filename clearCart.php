<?php
// Подключение к базе данных
function connectDB() {
    $servername = "localhost";
    $username = "postgres";
    $password = "1205";
    $dbname = "postgres";

    try {
        $conn = new PDO("pgsql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Очистка корзины
function clearCart() {
    $conn = connectDB();
    $sql = "DELETE FROM cart";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $conn = null;
}

clearCart();
echo json_encode(['success' => true]);
?>