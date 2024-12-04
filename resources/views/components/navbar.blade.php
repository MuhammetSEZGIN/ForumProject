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
            @auth

                <li class="nav-item">
                    <x-nav-item href="{{route('myArticles')}}">Makalelerim</x-nav-item>
                </li>

                <li class="nav-item">
                    <x-nav-item href="{{route('myComments')}}">Yorumlar</x-nav-item>
                </li>

                <li class="nav-item">
                    <x-nav-item href="{{route('addArticle')}}">Yeni Makale Ekle</x-nav-item>
                </li>

            @endauth
            @guest
                @if(!request()->is('login'))
                <li class="nav-item ms-auto">
                    <x-nav-item href="{{route('login')}}">Giriş Yap</x-nav-item>
                </li>
                @endif
            @endguest
            @auth
{{--                <li class="nav-item ms-auto">--}}
{{--                    <form action="{{route('logout')}}" method="POST">--}}
{{--                        @csrf--}}
{{--                        <button type="submit" class="btn btn-danger">Çıkış Yap</button>--}}
{{--                    </form>--}}
{{--                </li>--}}

                <li class="nav-item ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::getUser()["name"]}}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-center" href="{{route('todolist')}}">ToDoList</a></li>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <div class="d-grid gap-2 col-6 mx-auto ">
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Çıkış Yap</button>
                                </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth

        </ul>
    </div>
</nav>


