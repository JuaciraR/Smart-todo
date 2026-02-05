<?php

use App\Models\User;
use App\Models\Task;

test('authenticated user can access the task list', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/tasks');

    $response->assertStatus(200);
});

test('guest is redirected to login', function () {
    $response = $this->get('/tasks');

    $response->assertRedirect('/login');
});