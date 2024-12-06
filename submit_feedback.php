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
function addFeedback($feedback) {
    $conn = connectDB();
    $sql = "INSERT INTO feedback (name, phone, message, email) VALUES (:name, :phone, :message, :email)";
    $stmt = $conn->prepare($sql);
    error_log(json_encode($feedback));
    $stmt->execute([
        ':name' => $feedback['name'],
        ':phone' => $feedback['phone'],
        ':message' => $feedback['message'],
        ':email' => $feedback['email']
    ]);
    $conn = null;
}

$data = json_decode(file_get_contents('php://input'), true);
if ($data) {
    addFeedback($data);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>