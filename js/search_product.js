document.addEventListener('DOMContentLoaded', async () => {
    await loadProducts();

    document.getElementById('search-button').addEventListener('click', async () => {
        const query = document.getElementById('search-input').value;
        if (query) {
            const products = await searchProducts(query);
            displayProducts(products);
        }
    });
});

async function loadProducts() {
    const response = await fetch('/your-php-script.php?action=getProducts');
    const products = await response.json();
    displayProducts(products);
}

async function searchProducts(query) {
    const response = await fetch(`/your-php-script.php?action=getProducts`);
    const products = await response.json();
    return products.filter(product => product.name.toLowerCase().includes(query.toLowerCase()));
}

function displayProducts(products) {
    const productGrid = document.getElementById('product-grid');
    productGrid.innerHTML = '';
    products.forEach(product => {
        const productElement = document.createElement('div');
        productElement.classList.add('product-card');
        productElement.innerHTML = `
            <img src="${product.image_url}" alt="${product.name}">
            <h3>${product.name}</h3>
            <p>Цена: ${product.price} ₽/кг</p>
            <div class="card-buttons">
                <button class="add-to-cart" data-product='${JSON.stringify(product)}'>В Корзину</button>
                <button class="details-btn" data-product="${product.name.toLowerCase()}">Подробнее</button>
            </div>
        `;
        productGrid.appendChild(productElement);
    });
}