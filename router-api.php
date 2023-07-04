<?php
require_once("./libs/router.php");
require_once("./api/controllers/api.flight.controller.php");
require_once("./api/controllers/api.airport.controller.php");
require_once("./api/controllers/api.controller.php");
require_once("./api/views/api.view.php");

// Recurso solicitado
$resource = $_GET["resource"];

// Método utilizado
$method = $_SERVER["REQUEST_METHOD"];

// Instancia el router
$router = new Router();

// Flight
$router->addRoute("flight", "GET", "ApiFlightController", "showFlight");
$router->addRoute("flight/:ID", "GET", "ApiFlightController", "showFlightId");
$router->addRoute("flight/:ID", "DELETE", "ApiFlightController", "deleteFlight");
$router->addRoute("flight", "POST", "ApiFlightController", "addFlight");
$router->addRoute("flight/:ID", "PUT", "ApiFlightController", "editFlight");

// Airport
$router->addRoute("airport", "GET", "ApiAirportController", "showAirport");
$router->addRoute("airport/:ID", "GET", "ApiAirportController", "showAirportId");
$router->addRoute("airport/:ID", "DELETE", "ApiAirportController", "deleteAirport");
$router->addRoute("airport", "POST", "ApiAirportController", "addAirport");
$router->addRoute("airport/:ID", "PUT", "ApiAirportController", "editAirport");

// Rutea
$router->route($resource, $method);