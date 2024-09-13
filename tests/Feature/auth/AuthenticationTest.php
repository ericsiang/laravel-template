<?php

test('unauthenticate user', function () {
    $response = $this->get(route('user.show',[2]));
    $response->assertStatus(401);
});

test('authenticate user', function () {
    //login get token
    $loginResponse = $this->get(route('user.login',['name'=>'dd','line_id'=>'testing_line_id']));

    $response = $this->get(route('user.show',[2]),headers:['Authorization'=>'Bearer '.$loginResponse['token']]);
    // dd($response);
    $response->assertStatus(200);
});
