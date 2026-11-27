'use strict';

document.querySelectorAll('.delete-form').forEach((delete_form) => {
    delete_form.addEventListener('submit', (event) => {
        if (!window.confirm('この商品を削除しますか？')) {
            event.preventDefault();
        }
    });
});
