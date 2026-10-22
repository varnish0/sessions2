<?php

use App\Models\User;

test('home page renders pages.home view with nav link to user create', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertViewIs('pages.home');
    $response->assertSee(route('users.create'));
    $response->assertSee('Crear cuenta');
});

test('user create page renders pages.create view with partial form', function () {
    $response = $this->get(route('users.create'));

    $response->assertOk();
    $response->assertViewIs('pages.create');
    $response->assertSee('Sesiones');
    $response->assertSee(route('users.store'));
    $response->assertSee('Crear Usuario');
    $response->assertSee('Nombre:');
    $response->assertSee('Correo electrónico:');
});

test('creating a user redirects to home with success message', function () {
    $response = $this->post(route('users.store'), [
        'name' => 'Juan Perez',
        'email' => 'juan@example.com',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
    ]);

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('success', 'Usuario creado correctamente.');

    $this->assertDatabaseHas('users', [
        'name' => 'Juan Perez',
        'email' => 'juan@example.com',
    ]);
});

test('user creation requires valid data', function () {
    $response = $this->post(route('users.store'), [
        'name' => '',
        'email' => 'not-an-email',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'password']);
    expect(User::count())->toBe(0);
});

test('handles exceptions gracefully when user creation fails', function () {
    User::saving(function () {
        throw new Exception('Database failure');
    });

    $response = $this->post(route('users.store'), [
        'name' => 'Juan Perez',
        'email' => 'juan@example.com',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    expect(session('error'))->toContain('Database failure');
});
