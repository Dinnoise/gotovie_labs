document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const productGrid = document.getElementById('product-grid');
    const productCards = productGrid.getElementsByClassName('product-card');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        Array.from(productCards).forEach(card => {
            const productName = card.querySelector('h3').textContent.toLowerCase();
            if (productName.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});