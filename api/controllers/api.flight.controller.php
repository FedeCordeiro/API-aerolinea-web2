<?php

require_once("./api/models/api.flight.model.php");
require_once("./api/models/api.airport.model.php");
require_once("./api/controllers/api.controller.php");
require_once("./api/views/api.view.php");

class ApiFlightController extends ApiController
{

    private $ApiFlightModel;
    private $ApiView;
    private $ApiAirportModel;

    public function __construct()
    {
        parent::__construct();
        $this->ApiFlightModel = new ApiFlightModel();
        $this->ApiView = new ApiView();
        $this->ApiAirportModel = new ApiAirportModel();
    }

    public function showFlight()
{
    $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : '';
    $order = isset($_GET['direction']) ? $_GET['direction'] : '';
    $page = isset($_GET['page']) ? $_GET['page'] : null;
    $limit = 3; // Límite fijo de 3 vuelos por página

    // Obtener el campo de destino para filtrar
    $destination = isset($_GET['destination']) ? $_GET['destination'] : '';

    if ($orderBy && $order) {
        if ($order !== 'asc' && $order !== 'desc') {
            // Error 400 - Solicitud incorrecta
            $this->ApiView->response("El ordenamiento de manera '$order' no es valido. Los posibles valores son 'asc' o 'desc'", 400);
            return;
        }

        $flights = $this->ApiFlightModel->getFlightsOrderedByAttribute($orderBy, $order);
    } elseif ($destination) {
        // Validar el destino ingresado
        if (!$this->isValidDestination($destination)) {
            // Error 404 - No encontrado
            $this->ApiView->response("Vuelo con el destino = $destination, no fue encontrado en la base de datos", 404);
            return;
        }

        $flights = $this->ApiFlightModel->getFlightsByDestination($destination);
    } else {
        $flights = $this->ApiFlightModel->getAllFlight();
    }

    // Si se especifica la página, realizar paginación
    if ($page !== null) {
        $response = $this->paginateFlights($flights, $page, $limit);
        if ($response === null) {
            return; // Finalizar la ejecución en caso de error
        }
    } else {
        $response = $flights; // Mostrar todos los vuelos sin paginación
    }

    $this->ApiView->response($response, 200);
}


    private function paginateFlights($flights, $page, $limit)
    {
        // Validar página actual
        $totalFlights = count($flights);
        $totalPages = ceil($totalFlights / $limit);

        // Verificar si la página está fuera de rango
        if ($page < 1 || $page > $totalPages) {
            $this->ApiView->response("Página no encontrada", 404);
            return null;
        }

        // Obtener los vuelos de la página actual
        $offset = ($page - 1) * $limit;
        $flights = array_slice($flights, $offset, $limit);

        $response = [
            'page' => $page,
            'totalPages' => $totalPages,
            'flights' => $flights
        ];

        return $response;
    }

    public function showFlightId($params = null)
    {
        // obtiene el parametro de la ruta
        $id = $params[':ID'];

        $flight = $this->ApiFlightModel->getFlightsById($id);

        if ($flight) {
            $this->ApiView->response($flight, 200);
        } else {
            $this->ApiView->response("No existe un vuelo asociado a el id = {$id}", 404);
        }
    }

    public function deleteFlight($params = [])
    {
        $id_flight = $params[':ID'];
        $flightId = $this->ApiFlightModel->getFlightsById($id_flight);
        if ($flightId) {
            $this->ApiFlightModel->deleteFlightById($id_flight);
            $this->ApiView->response("Vuelo con el id = $id_flight eliminado con éxito", 200);
        } else
            $this->ApiView->response("Vuelo con el id = $id_flight, no fue encontrado en la base de datos", 404);
    }

    public function addFlight($params = [])
    {
        $flight = $this->getData(); // lo obtengo del body

        // Verificar y validar los datos
        if (!isset($flight->destination) || !isset($flight->price) || !isset($flight->duration)) {
            $this->ApiView->response("Faltan los campos obligatorios", 400);
            return;
        }

        if ($this->isValidDestination($flight->destination)) {

            $minPrice = 10000;
            $maxPrice = 50000;
            // Validar el precio
            if ($flight->price > $minPrice && $flight->price < $maxPrice) {
                $flightId = $this->ApiFlightModel->insertFlight('', $flight->destination, $flight->price, $flight->duration);

                $newFlight = $this->ApiFlightModel->getFlightsById($flightId);

                if ($newFlight) {
                    $this->ApiView->response($newFlight, 201);
                } else {
                    $this->ApiView->response("Error al insertar un nuevo vuelo", 500);
                }
            } else {
                $this->ApiView->response("El precio ingresado no es válido, el precio del vuelo debe ser mayor a $minPrice y menor a $maxPrice", 400);
            }
        } else {
            $this->ApiView->response("El destino ingresado no es válido", 400);
        }
    }

    private function isValidDestination($destination)
    {
        $airports = $this->ApiAirportModel->getAllAirport();

        foreach ($airports as $airport) {
            if ($destination == $airport->id_airport) {
                return true;
            }
        }

        return false;
    }

    public function editFlight($params = [])
    {
        $id_flight = $params[':ID'];
        $flight = $this->ApiFlightModel->getFlightsById($id_flight);

        if ($flight) {
            $body = $this->getData();

            $flightData = [
                'destination' => $body->destination,
                'price' => $body->price,
                'duration' => $body->duration
            ];

            $this->ApiFlightModel->editFlight($id_flight, $flightData);

            $this->ApiView->response("Vuelo con el id = $id_flight, actualizado con éxito", 200);
        } else {
            $this->ApiView->response("Vuelo con el id = $id_flight, no fue encontrado en la base de datos", 404);
        }
    }
}
