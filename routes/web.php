<?php

$router->get('/games', 'GameController@index');
$router->post('/games','GameController@store')->middleware('csrf');
$router->post('/games/delete', 'GameController@delete')->middleware('csrf');
$router->get('/games/edit', 'GameController@edit');
$router->post('/games/update', 'GameController@update')->middleware('csrf');
$router->get('/api/games', 'ApiGameController@index');
$router->post('/api/games', 'ApiGameController@store');
$router->get('/api/games/{id}', 'ApiGameController@show');
$router->put('/api/games/{id}', 'ApiGameController@update');
$router->delete('/api/games/{id}', 'ApiGameController@destroy');

?>