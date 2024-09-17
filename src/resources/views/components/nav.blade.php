<div class="nav">
    <div class="flex align-items-center nav__content">
        <div id="open"><i class="bi bi-list"></i></div>
        <h1 class="nav__ttl">Rese</h1>
    </div>
    <div id="mask" class="hidden"></div>
    <section id="modal" class="hidden">
        <div id="close"><i class="bi bi-x"></i></div>
        <nav class="modal__nav">
            <ul class="modal__nav--list">
                <li class="modal__nav--item"><a href="{{ route('index') }}">HOME</a></li>
                @if( Auth::check() )
                <li class="modal__nav--item">
                    <form class="form" action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="modal__nav--button">Logout</button>
                    </form>
                </li>
                <li class="modal__nav--item"><a href="{{ route('mypage') }}">Mypage</a></li>
                @else
                <li class="modal__nav--item"><a href="{{ route('showRegister') }}">Registration</a></li>
                <li class="modal__nav--item"><a href="{{ route('showLogin') }}">Login</a></li>
                @endif
            </ul>
        </nav>
    </section>
    <script src="/js/nav.js"></script>
</div>
