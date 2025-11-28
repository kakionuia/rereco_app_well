<?php

it('has leylahanafi4@gmail.com page', function () {
    $response = $this->get('/leylahanafi4@gmail.com');

    $response->assertStatus(200);
});
