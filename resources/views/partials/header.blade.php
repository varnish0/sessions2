<header>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            @if (session('token'))
                <li>Hola, {{ session('name') }}</li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                <li><a href="{{ route('users.create') }}">Crear cuenta</a></li>
            @endif
        </ul>
    </nav>
</header>
