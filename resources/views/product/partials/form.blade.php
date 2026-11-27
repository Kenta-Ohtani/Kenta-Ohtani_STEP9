<div class="form__group">
    <label for="productName">商品名</label>
    <input
        id="productName"
        name="product_name"
        type="text"
        value="{{ old('product_name', $product?->product_name) }}"
        required
    >
</div>

<div class="form__group">
    <label for="price">価格</label>
    <input
        id="price"
        name="price"
        type="number"
        min="0"
        value="{{ old('price', $product?->price) }}"
        required
    >
</div>

<div class="form__group">
    <label for="description">商品説明</label>
    <textarea
        id="description"
        name="description"
        rows="6"
        maxlength="255"
        required
    >{{ old('description', $product?->description) }}</textarea>
</div>

<div class="form__group">
    <label for="stock">在庫数</label>
    <input
        id="stock"
        name="stock"
        type="number"
        min="0"
        value="{{ old('stock', $product?->stock) }}"
        required
    >
</div>

<div class="form__group">
    <label for="imgPath">商品画像</label>

    @if($product !== null)
        <img
            src="{{ asset('storage/' . $product->img_path) }}"
            alt="現在の商品画像"
            class="form-page__current-image"
        >
    @endif

    <input
        id="imgPath"
        name="img_path"
        type="file"
        accept="image/jpeg,image/png,image/webp"
        {{ $product === null ? 'required' : '' }}
    >
</div>
