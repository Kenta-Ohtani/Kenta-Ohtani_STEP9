<footer class="site-footer">
    <a href="{{ route('contact.index') }}" class="button button--primary">
        お問い合わせ
    </a>

    <div class="site-footer__links">
        <a href="{{ route('product.index') }}">Home</a>
        <a href="{{ route('mypage.index') }}">マイページ</a>
    </div>

    <small>&copy; {{ date('Y') }} MyShop</small>
</footer>
