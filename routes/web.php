<?php

$router->get('/games', 'GameController@index');
$router->post('/games','GameController@store')->middleware('csrf');
$router->get('/games/delete', 'GameController@delete');
$router->get('/games/edit', 'GameController@edit');
$router->post('/games/update', 'GameController@update')->middleware('csrf');
$router->get('/api/games', 'ApiGameController@index');
$router->post('/api/games', 'ApiGameController@store');
$router->get('/api/games/{id}', 'ApiGameController@show');
$router->put('/api/games/{id}', 'ApiGameController@update');

?>