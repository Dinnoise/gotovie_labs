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

// Получение информации о товаре по ID
function getProductById($id) {
    $conn = connectDB();
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $product;
}

// Получение ID товара из GET-запроса
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = getProductById($productId);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товар - <?= $product['name'] ?></title>
    <link rel="stylesheet" href="./styles/products.css">
</head>
<body>
    <!-- Навигация -->
    <header>
        <nav>
            <ul>
                <img src="./images/logo_1.jpg" alt="Логотип сайта" height="50">
                <li><a href="index.html">Главная страница</a></li>
                <li><a href="list.php">Каталог</a></li>
                <li><a href="#">О нас</a></li>
                <li><a href="cart.php">Корзина</a></li>
            </ul>
        </nav>
    </header>

    <!-- Секция товара -->
    <main>
        <section class="product-page">
            <div class="product-image">
                <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>" />
            </div>
            <div class="product-details">
                <h1><?= $product['name'] ?></h1>
                <p><?= $product['description'] ?></p>
                <!-- Кнопка для модального окна -->
                <button id="open-modal" class="add-to-cart">Энергетическая ценность</button>

                <div class="product-price">
                    <p><?= $product['price'] ?> ₽ <span>за 1 кг.</span></p>
                    <div class="quantity-container">
                        <label for="quantity">Вес:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" step="1">
                        <span>кг.</span>
                    </div>
                </div>
                <button class="add-to-cart" data-product='<?= json_encode($product) ?>'>Добавить в корзину</button>
            </div>
        </section>
    </main>

    <!-- Модальное окно -->
    <div class="modal" id="energy-modal">
        <div class="modal-content">
            <button class="close-modal" id="close-modal">Закрыть</button>
            <h2>Энергетическая ценность</h2>
            <p>Бананы — это отличный источник энергии. Средняя энергетическая ценность бананов составляет:</p>
            <ul>
                <li>Калории: 96 ккал на 100 г</li>
                <li>Белки: 1.3 г</li>
                <li>Жиры: 0.3 г</li>
                <li>Углеводы: 21 г</li>
                <li>Клетчатка: 2.6 г</li>
            </ul>
        </div>
    </div>

    <!-- Футер -->
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
                <p>Помощь</p>
            </div>
            <div class="footer-section">
                <h3>Связаться с нами</h3>
                <p>☎️ +79278324702</p>
                <p>📧 kirya.saygin@mail.ru</p>
                <p>@D1nnoise</p>
            </div>
        </div>
    </footer>

    <script>
        // Получаем элементы модального окна
        const openModalButton = document.getElementById('open-modal');
        const closeModalButton = document.getElementById('close-modal');
        const modal = document.getElementById('energy-modal');

        // Функция для открытия модального окна
        openModalButton.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        // Функция для закрытия модального окна
        closeModalButton.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Закрытие модального окна при клике на затемнённый фон
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>
</html>