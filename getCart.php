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

// Получение всех товаров из корзины
function getCartItems() {
    $conn = connectDB();
    $sql = "SELECT * FROM cart";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

$cartItems = getCartItems();
echo json_encode($cartItems);
?>