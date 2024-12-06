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

$products = getProducts();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог - FruitFresh</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/modal.css">
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
        <section class="catalog">
            <h1>Товары</h1>
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Поиск по каталогу..." />
            </div>

            <div class="product-grid" id="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>">
                        <h3><?= $product['name'] ?></h3>
                        <p>Цена: <?= $product['price'] ?> ₽/кг</p>
                        <div class="card-buttons">
                            <button class="add-to-cart" data-product='<?= json_encode($product) ?>'>В Корзину</button>
                            <button><a href="product.php?id=<?= $product['id'] ?>" class="details-btn">Подробнее</a></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- Модальное окно -->
    <div class="modal" id="product-modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div class="modal-body">
                <img src="" alt="Product Image" id="modal-image">
                <h3 id="modal-title"></h3>
                <p><strong>Энергетическая ценность:</strong> <span id="modal-energy"></span></p>
                <div class="product-price">
                    <p>Цена: <span id="modal-price"></span> ₽/кг</p>
                    <div class="quantity-container">
                        <label for="modal-quantity">Вес:</label>
                        <input type="number" id="modal-quantity" name="quantity" value="1" min="1" step="1">
                        <span>кг.</span>
                    </div>
                </div>
                <button class="add-to-cart">Добавить в корзину</button>
            </div>
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
    <script src="./js/script.js" defer></script>
    <script src="./js/cart_script.js" defer></script>
    <script src="js/search_script.js" defer></script>
    <script src="js/search_product.js" defer></script>
</body>
</html>