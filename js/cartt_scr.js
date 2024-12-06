document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const productData = JSON.parse(button.getAttribute('data-product'));
            const quantity = document.getElementById('quantity').value;

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product: productData,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Товар добавлен в корзину');
                } else {
                    alert('Ошибка при добавлении товара в корзину');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});