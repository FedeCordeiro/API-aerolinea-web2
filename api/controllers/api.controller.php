<?php

require_once("./api/views/api.view.php");

class ApiController
{

    private $data;

    public function __construct()
    {
        $this->data = file_get_contents("php://input");
    }

    protected function getData()
    {
        return json_decode($this->data);
    }
}
