<?php
class ApiFlightModel
{

    private $db;

    public function __construct()
    {
        // Conectar a la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=db_airline;charset=utf8', 'root', '');
    }

    // Función para obtener todos los registros de vuelo
    public function getAllFlight()
    {
        $query = $this->db->prepare("SELECT * FROM flight");
        $query->execute();

        $flights = $query->fetchAll(PDO::FETCH_OBJ);

        return $flights;
    }


    // Función para obtener un vuelo por su ID
    public function getFlightsById($flightId)
    {
        $query = $this->db->prepare("SELECT * FROM flight WHERE id_flight = :flightId");
        $query->bindParam(":flightId", $flightId);
        $query->execute();

        $flightId = $query->fetch(PDO::FETCH_OBJ);

        return $flightId;
    }

    // Función para editar un vuelo
    function editFlight($id_flight, $flight)
    {
        $query = $this->db->prepare('UPDATE flight SET destination=?, price=?, duration=? WHERE id_flight=?');
        $query->execute([$flight['destination'], $flight['price'], $flight['duration'], $id_flight]);
    }


    // Función para eliminar un vuelo por su ID
    function deleteFlightById($id)
    {
        $query = $this->db->prepare('DELETE FROM flight WHERE id_flight = ?');
        $query->execute([$id]);
    }

    // Función para insertar un nuevo vuelo
    public function insertFlight($id_flight, $destination, $price, $duration)
    {
        $query = $this->db->prepare("INSERT INTO flight (id_flight, destination, price, duration) VALUES (?, ?, ?, ?)");
        $query->execute([$id_flight, $destination, $price, $duration]);

        $lastInsertedId = $this->db->lastInsertId();
        return $lastInsertedId;
    }

    function getFlightByAirport($id_airport)
    {
        $query = $this->db->prepare("SELECT * FROM flight WHERE destination=?");
        $query->execute([$id_airport]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFlightsOrderedByAttribute($attribute, $order)
    {
        $validAttributes = ['id_flight', 'destination', 'price', 'duration'];
        if (!in_array($attribute, $validAttributes)) {
            return false;
        }

        $query = "SELECT * FROM flight ORDER BY $attribute $order";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $flights = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $flights;
    }

    public function getFlightsByDestination($destination)
    {
        // 1. Preparar la consulta
        $query = "SELECT * FROM flight WHERE destination = :destination";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':destination', $destination);

        // 2. Ejecutar la consulta
        $stmt->execute();

        // 3. Obtener los resultados
        $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $flights;
    }

}
