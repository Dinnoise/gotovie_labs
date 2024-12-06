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

// Получение всех данных из всех таблиц
function getAllData() {
    $conn = connectDB();
    $tables = ['products', 'feedback', 'cart']; // Добавьте другие таблицы по мере необходимости
    $data = [];

    foreach ($tables as $table) {
        $sql = "SELECT * FROM $table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data[$table] = $result;
    }

    $conn = null;
    return $data;
}

// Получение всех товаров
function getProducts() {
    $conn = connectDB();
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

// Обработка GET-запроса для получения данных
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'getAllData') {
        $data = getAllData();
        echo json_encode($data);
        exit;
    } elseif (isset($_GET['action']) && $_GET['action'] === 'getProducts') {
        $data = getProducts();
        echo json_encode($data);
        exit;
    }
}

// Сохранение данных из формы обратной связи
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $conn = connectDB();
    $sql = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $email, $message]);
    $conn = null;

    echo json_encode(['success' => true]);
}
?>