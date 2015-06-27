<?php
use Cake\Routing\Router;

Router::plugin('Autobake', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
