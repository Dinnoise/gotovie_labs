document.addEventListener('DOMContentLoaded', function() {
    const checkoutButton = document.getElementById('checkout-button');
    const clearCartButton = document.getElementById('clear-cart-button');
    const cartItems = document.getElementById('cart-items');
    const totalPrice = document.getElementById('total-price');
    const modal = document.getElementById('payment-modal');
    const closeButton = document.querySelector('.close-button');

    function loadCart() {
        fetch('/getCart.php')
            .then(response => response.json())
            .then(data => {
                let total = 0;
                cartItems.innerHTML = '';
                data.forEach(product => {
                    const item = document.createElement('div');
                    item.classList.add('cart-item');
                    item.innerHTML = `
                        <img src="${product.image}" alt="${product.name}" width="50">
                        <h3>${product.name}</h3>
                        <p>Цена: ${product.price} ₽/кг</p>
                        <p>Количество: 1 кг</p>
                        <p>Сумма: ${product.price} ₽</p>
                    `;
                    cartItems.appendChild(item);
                    total += product.price;
                });
                totalPrice.textContent = total.toFixed(2); // Округляем до 2 знаков после запятой
            })
            .catch(error => console.error('Error loading cart:', error));
    }

    checkoutButton.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    clearCartButton.addEventListener('click', function() {
        fetch('/clearCart.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cartItems.innerHTML = '';
                totalPrice.textContent = '';
                alert('Корзина очищена');
            }
        })
        .catch(error => console.error('Error clearing cart:', error));
    });

    closeButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    loadCart();
});
    document.addEventListener('DOMContentLoaded', function() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productData = JSON.parse(button.getAttribute('data-product'));
                addToCart(productData);
            });
        });
    
        function addToCart(product) {
            fetch('/addToCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(product)
            })
            .then(data => console.log(data))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Товар добавлен в корзину');
                    loadCart(); // Обновляем корзину после добавления товара
                } else {
                    alert('Ошибка при добавлении товара в корзину');
                }
            })
            .catch(error => console.error('Error adding to cart:', error));
        }
    
        function loadCart() {
            fetch('/getCart.php')
                .then(response => response.json())
                .then(data => {
                    let total = 0;
                    const cartItems = document.getElementById('cart-items');
                    const totalPrice = document.getElementById('total-price');
                    cartItems.innerHTML = '';
                    data.forEach(product => {
                        const item = document.createElement('div');
                        item.classList.add('cart-item');
                        item.innerHTML = `
                            <img src="${product.image}" alt="${product.name}" width="50">
                            <h3>${product.name}</h3>
                            <p>Цена: ${product.price} ₽/кг</p>
                            <p>Количество: 1 кг</p>
                            <p>Сумма: ${product.price} ₽</p>
                        `;
                        cartItems.appendChild(item);
                        total += parseInt(product.price);
                    });
                    totalPrice.textContent = total.toFixed(2); // Округляем до 2 знаков после запятой
                })
                .catch(error => console.error('Error loading cart:', error));
        }
    
        loadCart(); // Загружаем корзину при загрузке страницы
    });