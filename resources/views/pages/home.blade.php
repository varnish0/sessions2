@extends('layouts.app')

@section('content')
    <h1>Página Principal</h1>

    <section>
        <h2>Usuarios Registrados</h2>
        @if (isset($users) && $users->isNotEmpty())
            <ul>
                @foreach ($users as $user)
                    <li>{{ $user->name }} ({{ $user->email }})</li>
                @endforeach
            </ul>
        @else
            <p>No hay usuarios registrados.</p>
        @endif
    </section>
@endsection
