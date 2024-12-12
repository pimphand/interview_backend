<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Employee;

uses(RefreshDatabase::class);


test('user can login', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
});

test('user can fetch employees', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    Employee::factory()->count(10)->create();

    $response = $this->getJson('/api/employees', [
        'Authorization' => 'Bearer ' . $response['access_token'],
    ]);

    $response->assertStatus(200);
});

test('user can create employee', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->postJson('/api/employees', [
        'name' => 'John Doe',
        'email' => 'email@gmail.com',
        'dob' => '1990-01-01',
        'city' => 'Lagos',
    ], [
        'Authorization' => 'Bearer ' . $response['access_token'],
    ]);

    $response->assertStatus(201);
});

test('user can update employee', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $employee = Employee::factory()->create();

    $response = $this->putJson('/api/employees/' . $employee->id, [
        'name' => 'John Updated',
        'email' => 'updated@gmail.com',
        'dob' => '1980-01-01',
        'city' => 'New York',
    ], [
        'Authorization' => 'Bearer ' . $response['access_token'],
    ]);

    $response->assertStatus(200);
});

test('user can delete employee', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $employee = Employee::factory()->create();

    $response = $this->deleteJson('/api/employees/' . $employee->id, [], [
        'Authorization' => 'Bearer ' . $response['access_token'],
    ]);

    $response->assertStatus(200);
});

test('user can update activate employee', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $employee = Employee::factory()->create();

    $response = $this->putJson('/api/employees/activate/' . $employee->id, [
        'is_active' => 0
    ], [
        'Authorization' => 'Bearer ' . $response['access_token'],
    ]);

    $response->assertStatus(200);
});

test('user can logout', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $response = $this->postJson('/api/logout', [], [
        'Authorization' => 'Bearer ' . $response['access_token'],
    ]);

    $response->assertStatus(200);
});

test('user can update status', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $user = User::factory()->create([
        'email' => 'update@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);

    $response = $this->putJson('/api/users/' . $user->id, [
        'is_active' => 0
    ], [
        'Authorization' => 'Bearer ' . $response['access_token'],
    ]);

    $response->assertStatus(200);
});

test('user can check In attendance', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->post('api/attendance-check-in', [
        'Authorization' => 'Bearer ' . $response['access_token'],
    ]);

    $response->assertStatus(200);
});

test('Validate attendance check In check to prevent duplicate input.', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);

    $token = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $response = $this->post('api/attendance-check-in', [
        'Authorization' => 'Bearer ' . $token['access_token'],
    ]);

    $response = $this->post('api/attendance-check-in', [
        'Authorization' => 'Bearer ' . $token['access_token'],
    ]);

    $response->assertStatus(400);
});

test('user can check Out attendance', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);

    $token = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->post('api/attendance-check-in', [
        'Authorization' => 'Bearer ' . $token['access_token'],
    ]);

    $response = $this->post('api/attendance-check-out', [
        'Authorization' => 'Bearer ' . $token['access_token'],
    ]);

    $response->assertStatus(200);
});

test('Validate attendance check Out check to prevent duplicate input.', function () {
    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
        'name' => 'Test User',
    ]);

    $token = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $response = $this->post('api/attendance-check-out', [
        'Authorization' => 'Bearer ' . $token['access_token'],
    ]);

    $response = $this->post('api/attendance-check-out', [
        'Authorization' => 'Bearer ' . $token['access_token'],
    ]);

    $response->assertStatus(400);
});
