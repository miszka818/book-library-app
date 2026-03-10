<?php

use App\Models\User;
use Laravel\Fortify\Features;

test('two factor settings page returns correct JSON', function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->getJson(route('two-factor.show'));

    $response->assertOk()
             ->assertJson([
                 'twoFactorEnabled' => false,
                 'requiresConfirmation' => true,
             ]);
});