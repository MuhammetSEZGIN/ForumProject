<nav class="navbar navbar-light bg-body-tertiary">
    <div class="container">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
                <x-nav-item href="{{route('mainMenu')}}">
                    <img src="{{asset("images/logo.png")}}" alt="logo" width="40" height="24" class="d-inline-block align-text-top">
                </x-nav-item>
            </li>
            <li class="nav-item">
                <x-nav-item href="{{route('LastArticles')}}">Son Yazılar</x-nav-item>
            </li>
            <li class="nav-item">
                <x-nav-item href="{{route('PopularArticles')}}">En Çok Okunanlar</x-nav-item>
            </li>
            @guest
                @if(!request()->is('login'))
                <li class="nav-item ms-auto">
                    <x-nav-item href="{{route('login')}}">Giriş Yap</x-nav-item>
                </li>
                @endif
            @endguest
            @auth
                <li class="nav-item ms-auto">
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Çıkış Yap</button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</nav>


