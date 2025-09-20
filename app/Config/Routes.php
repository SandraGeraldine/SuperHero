<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/reportes/reporte1','ReporteController::getReport1');
$routes->get('/reportes/reporte2','ReporteController::getReport2');
$routes->get('/reportes/reporte3','ReporteController::getReport3');
$routes->get('/reportes/index','ReporteController::index');
$routes->get('/reportes/reporte4','ReporteController::getReport4');
$routes->post('/reportes/reporte4', 'ReporteController::getReport4');

