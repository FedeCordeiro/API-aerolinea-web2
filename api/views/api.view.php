<?php

class ApiView
{

    // Devuelve un arreglo en formato JSON y maneja el codigo respuesta
    public function response($data, $status)
    {
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        echo json_encode($data);
    }

    //Asocia un codigo de respuesta a un mensaje HTTP
    private function _requestStatus($code)
    {
        $status = array(
            200 => "OK",
            201 => "Create",
            400 => "Bad Request",
            404 => "Not Found",
            500 => "Internal Server Error"
        );
        return (isset($status[$code])) ? $status[$code] : $status[500];
    }
}
