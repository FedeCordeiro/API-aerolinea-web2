<?php

class ApiAirportModel
{

    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=db_airline;charset=utf8', 'root', '');
    }

    public function getAllAirport()
    {
        $query = $this->db->prepare("SELECT * FROM airport");
        $query->execute();

        $airports = $query->fetchAll(PDO::FETCH_OBJ);

        return $airports;
    }

    public function getAirportsById($airportId)
    {
        $query = $this->db->prepare("SELECT * FROM airport WHERE id_airport = :airportId");
        $query->bindParam(":airportId", $airportId);
        $query->execute();

        $airport = $query->fetch(PDO::FETCH_OBJ);

        return $airport;
    }

    function editAirport($id_airport, $airport)
    {
        $query = $this->db->prepare('UPDATE airport SET name=?, ubication=?, image=? WHERE id_airport=?');
        $query->execute([$airport['name'], $airport['ubication'], $airport['image'], $id_airport]);
    }

    function deleteAirportById($id)
    {
        $query = $this->db->prepare('DELETE FROM airport WHERE id_airport = ?');
        $query->execute([$id]);
    }

    public function insertAirport($name, $ubication, $image)
    {
        $query = $this->db->prepare("INSERT INTO airport (name, ubication, image) VALUES (?, ?, ?)");
        $query->execute([$name, $ubication, $image]);

        $lastInsertedId = $this->db->lastInsertId();
        return $lastInsertedId;
    }

    public function getAirportsOrderedByAttribute($attribute, $order)
    {
        $validAttributes = ['id_airport', 'name', 'ubication', 'image'];
        if (!in_array($attribute, $validAttributes)) {
            return false;
        }

        $query = "SELECT * FROM airport ORDER BY $attribute $order";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $airports = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $airports;
    }

    public function getAirportsFilteredByName($name)
    {
        $name = '%' . $name . '%';

        $query = "SELECT * FROM airport WHERE name LIKE :name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
