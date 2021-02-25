<?php

$app->get('/', '\App\Controllers\HomeController:getHome')->setName('pocetna');
$app->get('/baze', '\App\Controllers\HomeController:getBaze')->setName('baze');
$app->post('/baze', '\App\Controllers\HomeController:postBaze')->setName('baze');
$app->get('/tabele', '\App\Controllers\HomeController:getTabele')->setName('tabele');
$app->post('/tabele', '\App\Controllers\HomeController:postTabele')->setName('tabele');
$app->get('/putanje', '\App\Controllers\HomeController:getPutanje')->setName('putanje');
$app->post('/putanje', '\App\Controllers\HomeController:postPutanje')->setName('putanje');
$app->post('/reset', '\App\Controllers\HomeController:postReset')->setName('reset');

$app->get('/podesavanja', '\App\Controllers\PodesavanjaController:getPodesavanja')->setName('podesavanja');
$app->post('/podesavanja', '\App\Controllers\PodesavanjaController:postPodesavanja')->setName('podesavanja');

$app->get('/skelet', '\App\Controllers\SkeletController:getSkelet')->setName('skelet');

$app->get('/pregled/{id}', '\App\Controllers\SkeletController:getPregled')->setName('pregled');







$app->get('/rute', '\App\Controllers\RuteController:getRute')->setName('rute');

$app->get('/model', '\App\Controllers\ModelController:getModel')->setName('model');

$app->get('/kontroler', '\App\Controllers\KontrolerController:getKontroler')->setName('kontroler');

$app->get('/pogled-pretraga', '\App\Controllers\PogledController:getPogled')->setName('pogled.pretraga');
$app->get('/pogled-dodavanje', '\App\Controllers\PogledController:getPogled')->setName('pogled.dodavanje');
$app->get('/pogled-izmena', '\App\Controllers\PogledController:getPogled')->setName('pogled.izmena');
