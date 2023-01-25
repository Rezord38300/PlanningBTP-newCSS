<?php
class Vehicule{
    private $plate;
    private $model;
    private $maxPassenger;
    private $license;

    function __construct(string $plate, string $model, string $max, string $license){
        $this->plate = $plate;
        $this->model = $model;
        $this->maxPassenger = $max;
        $this->license = $license;
    }

    function display(string $token): string{
        $str = "";
        $str .=  "<form class=\"vehicule\" action=\"delete.php\" method=\"post\">";
        $str .=  "<input type=\"text\" value=\"".$this->plate."\" name=\"id\" readonly>";
        $str .=  "<p>".$this->model."</p>";
        $str .=  "<p>".$this->maxPassenger."</p>";
        $str .=  "<p>".$this->license."</p>";
        $str .=  "<input type=\"hidden\" name=\"token\" value=\"".$token."\">";
        $str .=  "<input type=\"hidden\" name=\"table\" value=\"Vehicle\">";
        $str .=  "<input type=\"hidden\" name=\"idName\" value=\"vehicleLicensePlate\">";
        $str .=  "<input type=\"submit\" value=\"Effacer\">";
        $str .=  "</form>";
        return $str;
    }
}