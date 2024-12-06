document.addEventListener('DOMContentLoaded', () => {
    // Данные о товарах
    // const products = {
    //     grapefruit: {
    //         title: "Грейпфрут",
    //         image: "images/grapefruit-teaser.png",
    //         energy: "42 ккал/100г",
    //         price: 300
    //     },
    //     mango: {
    //         title: "Манго",
    //         image: "images/Mangos_-_single_and_halved.jpg",
    //         energy: "60 ккал/100г",
    //         price: 500
    //     },
    //     banana: {
    //         title: "Банан",
    //         image: "images/banana.jpg",
    //         energy: "96 ккал/100г",
    //         price: 150
    //     },
    //     pitaya: {
    //         title: "Питахайя",
    //         image: "images/pitaya.jpg",
    //         energy: "50 ккал/100г",
    //         price: 600
    //     }
    // };

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
                        total += product.price;
                    });
                    totalPrice.textContent = total.toFixed(2); // Округляем до 2 знаков после запятой
                })
                .catch(error => console.error('Error loading cart:', error));
        }
    
        loadCart(); // Загружаем корзину при загрузке страницы
    });
    
    // Переменные для модального окна
    const modal = document.getElementById('product-modal');
    const modalImage = document.getElementById('modal-image');
    const modalTitle = document.getElementById('modal-title');
    const modalEnergy = document.getElementById('modal-energy');
    const modalPrice = document.getElementById('modal-price');
    const closeModal = document.querySelector('.close-btn');

    // Открытие модального окна
    document.querySelectorAll('.details-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            const productKey = e.target.dataset.product;
            const product = products[productKey];

            // Устанавливаем данные в модальное окно
            modalImage.src = product.image;
            modalTitle.textContent = product.title;
            modalEnergy.textContent = product.energy;
            modalPrice.textContent = product.price;

            // Показываем окно
            modal.style.display = 'flex';
        });
    });

    // Закрытие модального окна
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Закрытие при клике вне модального окна
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});