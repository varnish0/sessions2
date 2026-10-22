@if ($errors->any())
    <div style="color: red;">
        <strong>Errores:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('login.attempt') }}" method="POST">
    @csrf

    <div>
        <label for="email">Correo electrónico o Usuario:</label>
        <input type="text" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <button type="submit">Iniciar Sesión</button>
    </div>
</form>
