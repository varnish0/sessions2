<?php

use App\Models\User;

test('login page renders correctly with login form', function () {
    $response = $this->get(route('login'));

    $response->assertOk();
    $response->assertViewIs('pages.login');
    $response->assertSee(route('login.attempt'));
    $response->assertSee('Iniciar Sesión');
    $response->assertSee('Correo electrónico o Usuario:');
    $response->assertSee('Contraseña:');
});

test('header displays guest buttons when no token in session', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Iniciar sesión');
    $response->assertSee('Crear cuenta');
    $response->assertDontSee('Cerrar sesión');
    $response->assertDontSee('Hola, ');
});

test('can login with valid credentials and sets token and name in session', function () {
    $user = User::create([
        'name' => 'Carlos Gomez',
        'email' => 'carlos@example.com',
        'password' => 'secret1234',
    ]);

    $response = $this->post(route('login.attempt'), [
        'email' => 'carlos@example.com',
        'password' => 'secret1234',
    ]);

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('success', 'Has iniciado sesión correctamente.');
    $response->assertSessionHas('token');
    $response->assertSessionHas('name', 'Carlos Gomez');
});

test('header displays greeting and logout button when token is in session', function () {
    $response = $this->withSession([
        'token' => 'test-token-12345',
        'name' => 'Carlos Gomez',
    ])->get(route('home'));

    $response->assertOk();
    $response->assertSee('Hola, Carlos Gomez');
    $response->assertSee('Cerrar sesión');
    $response->assertDontSee('Iniciar sesión');
    $response->assertDontSee('Crear cuenta');
});

test('login fails with invalid credentials', function () {
    User::create([
        'name' => 'Carlos Gomez',
        'email' => 'carlos@example.com',
        'password' => 'secret1234',
    ]);

    $response = $this->from(route('login'))->post(route('login.attempt'), [
        'email' => 'carlos@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('error', 'Credenciales incorrectas.');
    $response->assertSessionMissing('token');
});

test('logout clears session and redirects to login', function () {
    $response = $this->withSession([
        'token' => 'active-token-999',
        'name' => 'Carlos Gomez',
    ])->post(route('logout'));

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('success', 'Sesión cerrada correctamente.');
    $response->assertSessionMissing('token');
    $response->assertSessionMissing('name');
});
