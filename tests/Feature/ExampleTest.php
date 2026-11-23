<?php

test('guests are sent to login', function () {
    $response = $this->get('/');

    $response->assertRedirectToRoute('login');
});
