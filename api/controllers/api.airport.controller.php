<?php

require_once("./api/models/api.airport.model.php");
require_once("./api/controllers/api.controller.php");
require_once("./api/views/api.view.php");

class ApiAirportController extends ApiController
{

    private $ApiView;
    private $ApiAirportModel;

    public function __construct()
    {
        parent::__construct();
        $this->ApiView = new ApiView();
        $this->ApiAirportModel = new ApiAirportModel();
    }

    public function showAirport()
    {
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : '';
        $order = isset($_GET['direction']) ? $_GET['direction'] : '';
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $page = isset($_GET['page']) ? $_GET['page'] : null;
        $limit = 3; // Límite fijo de 3 aeropuertos por página
    
        if ($orderBy && $order) {
            if ($order !== 'asc' && $order !== 'desc') {
                // Error 400 - Solicitud incorrecta
                $this->ApiView->response("El ordenamiento de manera '$order' no es valido. Los posibles valores son 'asc' o 'desc'", 400);
                return;
            }
    
            $airports = $this->ApiAirportModel->getAirportsOrderedByAttribute($orderBy, $order);
        } elseif ($name) {
            // Validar el nombre ingresado
            if (!$this->isValidAirportName($name)) {
                // Error 404 - No encontrado
                $this->ApiView->response("Aeropuerto con el nombre = $name, no fue encontrado en la base de datos", 404);
                return;
            }
    
            $airports = $this->ApiAirportModel->getAirportsFilteredByName($name);
        } else {
            $airports = $this->ApiAirportModel->getAllAirport();
        }
    
        // Si se especifica la página, realizar paginación
        if ($page !== null) {
            $response = $this->paginateAirports($airports, $page, $limit);
            if ($response === null) {
                return; // Finalizar la ejecución en caso de error
            }
        } else {
            $response = $airports; // Mostrar todos los aeropuertos sin paginación
        }
    
        $this->ApiView->response($response, 200);
    }
    
    private function isValidAirportName($name)
    {
        $airports = $this->ApiAirportModel->getAllAirport();
    
        foreach ($airports as $airport) {
            if ($name == $airport->name) {
                return true;
            }
        }
    
        return false;
    }
    
    private function paginateAirports($airports, $page, $limit)
    {
        // Validar página actual
        $totalAirports = count($airports);
        $totalPages = ceil($totalAirports / $limit);
    
        // Verificar si la página está fuera de rango
        if ($page < 1 || $page > $totalPages) {
            $this->ApiView->response("Página no encontrada", 404);
            return null;
        }
    
        // Obtener los aeropuertos de la página actual
        $offset = ($page - 1) * $limit;
        $airports = array_slice($airports, $offset, $limit);
    
        $response = [
            'page' => $page,
            'totalPages' => $totalPages,
            'airports' => $airports
        ];
    
        return $response;
    }

    public function showAirportId($params = null)
    {
        // obtiene el parametro de la ruta
        $id = $params[':ID'];

        $airport = $this->ApiAirportModel->getAirportsById($id);

        if ($airport) {
            $this->ApiView->response($airport, 200);
        } else {
            $this->ApiView->response("No existe un aeropuerto asociado a el id= {$id}", 404);
        }
    }

    public function deleteAirport($params = [])
    {
        $id_airport = $params[':ID'];
        $airportId = $this->ApiAirportModel->getAirportsById($id_airport);
        if ($airportId) {
            $this->ApiAirportModel->deleteAirportById($id_airport);
            $this->ApiView->response("Aeropuerto con el id = $id_airport eliminado con éxito", 200);
        } else
            $this->ApiView->response("Aeropuerto con el id = $id_airport, no fue encontrado en la base de datos", 404);
    }

    public function addAirport($params = [])
    {
        $airport = $this->getData();

        // Verificar y validar los datos
        if (!isset($airport->name) || !isset($airport->ubication) || !isset($airport->image)) {
            $this->ApiView->response("Faltan los campos obligatorios", 400);
            return;
        }

        // Llamar al modelo para insertar el aeropuerto
        $airportId = $this->ApiAirportModel->insertAirport($airport->name, $airport->ubication, $airport->image);

        if ($airportId) {
            $newAirport = $this->ApiAirportModel->getAirportsById($airportId);
            $this->ApiView->response($newAirport, 201);
        } else {
            $this->ApiView->response("Error al insertar un nuevo aeropuerto", 500);
        }
    }

    public function editAirport($params = [])
    {
        $id_airport = $params[':ID'];
        $airport = $this->ApiAirportModel->getAirportsById($id_airport);

        if ($airport) {
            $body = $this->getData();

            $airportData = [
                'name' => $body->name,
                'ubication' => $body->ubication,
                'image' => $body->image
            ];

            $this->ApiAirportModel->editAirport($id_airport, $airportData);

            $this->ApiView->response("Aeropuerto con id = $id_airport actualizado con éxito", 200);
        } else {
            $this->ApiView->response("Aeropuerto con el id = $id_airport, no fue encontrado en la base de datos", 404);
        }
    }
}
