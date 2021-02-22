<?php

$app->get('/', '\App\Controllers\HomeController:getHome')->setName('pocetna');
$app->get('/baze', '\App\Controllers\HomeController:getBaze')->setName('baze');
$app->post('/baze', '\App\Controllers\HomeController:postBaze')->setName('baze');
$app->get('/tabele', '\App\Controllers\HomeController:getTabele')->setName('tabele');
$app->post('/tabele', '\App\Controllers\HomeController:postTabele')->setName('tabele');
$app->post('/reset', '\App\Controllers\HomeController:postReset')->setName('reset');

$app->get('/rute', '\App\Controllers\RuteController:getRute')->setName('rute');

$app->get('/model', '\App\Controllers\ModelController:getModel')->setName('model');

$app->get('/kontroler', '\App\Controllers\KontrolerController:getKontroler')->setName('kontroler');
$app->post('/kontroler', '\App\Controllers\KontrolerController:postKontroler')->setName('kontroler');

$app->get('/pogled', '\App\Controllers\PogledController:getPogled')->setName('pogled');
