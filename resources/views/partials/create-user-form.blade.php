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

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div>
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
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
        <label for="password_confirmation">Confirmar contraseña:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        @error('password_confirmation')
            <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <button type="submit">Crear Usuario</button>
    </div>
</form>
