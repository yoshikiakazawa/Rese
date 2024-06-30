'use strict';
{
    document.querySelectorAll('.heart_false, .heart_true').forEach((heart) => {
        heart.addEventListener('click', () => {
            let isFavorite = heart.classList.contains('heart_true');
            let shopId = heart.getAttribute('data-shop-id');

            fetch('/toggle-favorite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    shop_id: shopId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        heart.classList.toggle('heart_true', data.is_favorite);
                        heart.classList.toggle('heart_false', !data.is_favorite);
                    } else {
                        console.error('Failed to toggle favorite status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
}
