<?php

test('unauthorization user', function () {
    //login get token
    $loginResponse = $this->get(route('user.login', ['name' => 'dd', 'line_id' => 'testing_line_id']));

    $response = $this->get(route('user.index', [2]), headers: ['Authorization' => 'Bearer ' . $loginResponse['token']]);
    // dd($response);
    $response->assertStatus(403);
});
