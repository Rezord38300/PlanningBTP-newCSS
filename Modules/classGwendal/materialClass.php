<?php
class Material{
    private $designation;
    private $TTCount;
    private $cmtDispo;

    function __construct(string $des, int $tt, int $dispo){
        $this->designation = $des;
        $this->TTCount = $tt;
        $this->cmtDispo = $dispo;
    }

    function display(string $token) : string{
        $str  = "";
        $str .= "<form class=\"material\" action=\"delete.php\" method=\"post\">";
        $str .= "<input type=\"text\" value=\"".$this->designation."\" name=\"id\" readonly>";
        $str .= "<p>".$this->TTCount."</p>";
        $str .= "<p>".$this->cmtDispo."</p>";
        $str .= "<input  type=\"hidden\" name=\"token\" value=\"".$token."\">";
        $str .= "<input  type=\"hidden\" name=\"table\" value=\"Equipment\">";
        $str .= "<input  type=\"hidden\" name=\"idName\" value=\"equipmentName\">";
        $str .= "<input type=\"submit\" value=\"Effacer\">";
        $str .= "</form>";
        return $str;
    }
}