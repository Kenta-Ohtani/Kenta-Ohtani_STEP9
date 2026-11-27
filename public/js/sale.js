'use strict';

const purchase_card = document.querySelector('.purchase-card');
const quantity_input = document.getElementById('quantity');
const purchase_button = document.getElementById('purchaseButton');
const total_price = document.getElementById('totalPrice');

if (
    purchase_card !== null
    && quantity_input !== null
    && purchase_button !== null
    && total_price !== null
) {
    const unit_price = Number(purchase_card.dataset.unitPrice);
    const stock = Number(purchase_card.dataset.stock);

    const updatePurchaseState = () => {
        const quantity = Number(quantity_input.value);
        const is_valid = Number.isInteger(quantity)
            && quantity > 0
            && quantity <= stock;

        total_price.textContent = `￥${(
            unit_price * Math.max(quantity, 0)
        ).toLocaleString('ja-JP')}`;

        purchase_button.disabled = !is_valid;
    };

    quantity_input.addEventListener('input', updatePurchaseState);

    purchase_button.closest('form').addEventListener('submit', (event) => {
        const quantity = Number(quantity_input.value);
        const message = [
            '以下の内容で購入しますか？',
            `商品名：${document.title.replace(' - MyShop', '')}`,
            `個数：${quantity}`,
            `合計：￥${(unit_price * quantity).toLocaleString('ja-JP')}`,
        ].join('\n');

        if (!window.confirm(message)) {
            event.preventDefault();
        }
    });

    updatePurchaseState();
}
