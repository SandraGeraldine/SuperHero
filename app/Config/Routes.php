<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas de Reportes
$routes->get('reportes', 'ReporteController::index');
$routes->get('reportes/index', 'ReporteController::index');

// Reporte 1
$routes->get('reportes/reporte1', 'ReporteController::getReport1');

// Reporte 2
$routes->get('reportes/reporte2', 'ReporteController::getReport2');

// Reporte 3
$routes->get('reportes/reporte3', 'ReporteController::getReport3');

// Reporte 4
$routes->get('reportes/reporte4', 'ReporteController::getReport4');
$routes->post('reportes/reporte4', 'ReporteController::getReport4');

// Reporte 5
$routes->get('reportes/reporte5', 'ReporteController::getReport5');
$routes->post('reportes/SuperheroReport5', 'ReporteController::SuperheroReport5');
$routes->post('reportes/autocompleteSuperhero', 'ReporteController::autocompleteSuperhero');
$routes->post('reportes/Report5PDF', 'ReporteController::Report5PDF');

// Reporte 6 - Reporte personalizado
$routes->get('reportes/reporte6', 'ReporteController::getReport6');
$routes->post('reportes/reporte6-pdf', 'ReporteController::Report6PDF');
