document.addEventListener('DOMContentLoaded', () => {
    const likeButton = document.getElementById('like-button');
    const icon = document.getElementById('like-icon');
    const count = document.getElementById('like-count');

    console.log("like.js loaded");

    likeButton.addEventListener('click', function () {
        const itemId = this.dataset.id;
        console.log("clicked", itemId);

        fetch(`/items/${itemId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            count.textContent = data.count;

            if (data.status === 'liked') {
                icon.src = '/images/ハートロゴ_ピンク.png';
            } else {
                icon.src = '/images/ハートロゴ_デフォルト.png';
            }
        })
        .catch(err => console.error('Fetch error:', err));
    });
});