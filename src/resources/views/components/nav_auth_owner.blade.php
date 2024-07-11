<div class="nav">
    <div class="nav__content">
        <div id="open"><i class="bi bi-list"></i></div>
        <h1 class="nav__ttl">Rese Owner</h1>
    </div>
    <div id="mask" class="hidden"></div>
    <section id="modal" class="hidden">
        <div id="close"><i class="bi bi-x"></i></div>
        <nav class="modal__nav">
            <ul class="modal__nav--list">
                <li class="modal__nav--item"><a href="{{ route('index') }}">HOME</a></li>
                <li class="modal__nav--item"><a href="{{ route('showLogin') }}">一般Login</a></li>
            </ul>
        </nav>
    </section>
    <script src="/js/nav.js"></script>
</div>
