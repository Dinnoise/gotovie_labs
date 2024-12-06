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

// Добавление товара в корзину
function addToCart($product) {
    $conn = connectDB();
    $sql = "INSERT INTO cart (name, price, image, quantity) VALUES (:name, :price, :image, :quantity)";
    $stmt = $conn->prepare($sql);
    error_log(json_encode($product));
    $stmt->execute([
        ':name' => $product['name'],
        ':price' => $product['price'],
        ':image' => $product['image_url'],
        ':quantity' => 1
    ]);
    $conn = null;
}

$data = json_decode(file_get_contents('php://input'), true);
if ($data) {
    addToCart($data);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>