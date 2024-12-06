document.getElementById('feedback-form').addEventListener('submit', async (event) => {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    const response = await fetch('/submit_feedback.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    if (response.ok) {
        alert('Спасибо за вашу обратную связь!');
        event.target.reset();
    } else {
        alert('Ошибка при отправке формы');
    }
});