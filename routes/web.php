<?php

$router->get('/games', 'GameController@index');
$router->post('/games','GameController@store')->middleware('csrf');
$router->get('/games/delete', 'GameController@delete');
$router->get('/games/edit', 'GameController@edit');
$router->post('/games/update', 'GameController@update')->middleware('csrf');
$router->get('/api/games', 'ApiGameController@index');
?>