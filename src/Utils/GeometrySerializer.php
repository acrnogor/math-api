<?php
// src/Utils/GeometrySerializer
namespace App\Utils;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Session\Session;

class GeometrySerializer{

    const CIRCLE = "circle";
    const TRIANGLE = "triangle";

    private $session;

    public $type;

    public $radius;

    public $borders;

    public $round;

    public $surface;

    public $circumference;

    public function __construct($type){
        $session = new Session();
        $session -> start();

        $this -> type = $type;
        $this -> session = $session;
    }   

    // Getters
    public function setSurface(){
        if($this -> type == self::CIRCLE){
            $this -> surface = round(pow($this -> radius, 2) * pi(),$this -> round);
            $this -> session -> set("circle_surface", $this -> surface);
        }elseif($this -> type == self::TRIANGLE){
            $this -> surface = round(($this -> borders["a"] * $this -> height) / 2, $this -> round);
            $this -> session -> set("triangle_surface", $this -> surface);
        }else {
            throw new \Exception("Invalid geometry type");
        }
        
        
    }

    public function setCircumference(){
        if($this -> type == self::CIRCLE){
            $this -> circumference = round($this -> radius * 2 * pi(),$this -> round);
            $this -> session -> set("circle_circumference", $this -> circumference);
        }elseif($this -> type == self::TRIANGLE){
            $this -> circumference = round(array_sum($this -> borders) /2, $this -> round);
            $this -> session -> set("triangle_circumference", $this -> circumference);
        }else {
            throw new \Exception("Invalid geometry type");
        }
    }

    // Setters    
    public function setRadius($radius){
        $this -> radius = $radius;
    }

    public function setRound($round){
        $this -> round = $round;
    }

    public function setBorders($borders){
        if($this -> type != self::TRIANGLE){
            throw new \Exception("Invalid geometry type. Given $this->type, expected: ".self::TRIANGLE);
        }else {
            $this -> borders = $borders;
        }
    }
    public function setHeight($height){
        if($this -> type != self::TRIANGLE){
            throw new \Exception("Invalid geometry type. Given $this->type, expected: ".self::TRIANGLE);
        }else {
            $this -> height = $height;
        }
    }

    public function sumSurfaces(){
        return $session -> get("circle_surface") + $session -> get("triangle_surface");
    }

    public function sumCircumferences(){
        return $session -> get("circle_circumferences") + $session -> get("triangle_circumferences");
    }
}

?>
