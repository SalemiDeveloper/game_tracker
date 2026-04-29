<?php

$router->get('/games', 'GameController@index');

$router->post('/games','GameController@store');

$router->get('/games/delete', 'GameController@delete');

$router->get('/games/edit', 'GameController@edit');
$router->post('/games/update', 'GameController@update');
?>