<?php

use App\Models\User;

test('confirm password endpoint returns JSON when authenticated', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
                     ->getJson(route('password.confirm'));

    $response->assertOk()
             ->assertJson([
                 'message' => 'Confirm password endpoint',
             ]);
});

test('confirm password endpoint requires authentication', function () {
    $response = $this->getJson(route('password.confirm'));

    $response->assertStatus(401);
});