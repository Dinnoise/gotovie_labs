<?php
session_start();
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
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - FruitFresh</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/modal_cart.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <img src="./images/logo_1.jpg" alt="Логотип сайта" height="50">
                <li><a href="index.html">Главная страница</a></li>
                <li><a href="list.php">Каталог</a></li>
                <li><a href="about.html">О нас</a></li>
                <li><a href="cart.php">Корзина</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Корзина</h1>
            <div id="cart-items">
                
            </div>
            <div class="cart-summary">
                <p>Сумма заказа: <span id="total-price"></span> ₽</p>
                <div class="choice">
                    <button id="clear-cart-button">Очистить корзину</button>
                    <button id="checkout-button">Оформить заказ</button>
                </div>
            </div>
        </div>
    </main>

    <div id="payment-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Детали заказа</h2>

            <p>Скидка - нет</p>
            <p>Промокод - <input type="text" id="promo-code" placeholder="Промокод"></p>
            <p>Итого - сумма Р</p>
            <form id="payment-form">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="payment-method">Способ оплаты:</label>
                <select id="payment-method" name="payment-method" required>
                    <option value="credit-card">Кредитная карта</option>
                    <option value="paypal">PayPal</option>
                </select>
                <button type="submit">Оплатить</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3><img src="images/logo_1.jpg" alt="Логотип сайта" height="25"> FruittFresh</h3>
                <p>Наш магазин — это про вкус и качество.</p>
            </div>
            <div class="footer-section">
                <h3>О нас</h3>
                <p>Кто мы?</p>
                <p>Сотрудничество с нами</p>
                <p><a href="feedback.html">Помощь</a></p>
            </div>
            <div class="footer-section">
                <h3>Связаться с нами</h3>
                <p>☎️ +79278324702</p>
                <p>📧 kirya.saygin@mail.ru</p>
                <p>@D1nnoise</p>
            </div>
        </div>
    </footer>

    <script src="./js/cart_script.js" defer></script>
    <script src="./js/script.js" defer></script>
</body>
</html>