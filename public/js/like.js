'use strict';

const like_button = document.getElementById('likeButton');

if (like_button !== null) {
    like_button.addEventListener('click', async () => {
        like_button.disabled = true;

        try {
            const response = await fetch(like_button.dataset.url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                },
            });

            if (!response.ok) {
                throw new Error('お気に入り処理に失敗しました。');
            }

            const response_data = await response.json();

            like_button.classList.toggle(
                'like-button--active',
                response_data.is_liked
            );

            like_button.textContent = response_data.is_liked ? '♥' : '♡';
            like_button.setAttribute(
                'aria-pressed',
                response_data.is_liked ? 'true' : 'false'
            );
        } catch (error) {
            alert(error.message);
        } finally {
            like_button.disabled = false;
        }
    });
}
