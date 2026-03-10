<?php

use App\Models\User;
use Laravel\Fortify\Features;

test('two factor challenge redirects to login when not authenticated', function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    $response = $this->getJson(route('two-factor.login'));

    $response->assertStatus(302);
});

test('two factor challenge can be accessed as JSON when authenticated', function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->create();

    $user->forceFill([
        'two_factor_secret' => encrypt('test-secret'),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => now(),
    ])->save();

    $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertOk();

    $response = $this->getJson(route('two-factor.login'));

    $response->assertOk()
             ->assertJson([
                 'message' => 'Two factor challenge endpoint',
             ]);
});