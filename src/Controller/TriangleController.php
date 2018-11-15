<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Utils\GeometrySerializer;

class TriangleController extends AbstractController
{
    /**
     * @Route(
     *  "/triangle/{a}/{b}/{c}/{height}/{round}", 
     *  name="triangle",
     *  defaults={"round"=2},
     *  requirements={
     *      "a"= "^[0-9]*$",
     *      "b"= "^[0-9]*$",
     *      "c"= "^[0-9]*$",
     *      "height"= "^[0-9]*$"    
     *  }
     * )
     */
    public function index($a, $b, $c, $height, $round)
    {
        $triangle = new GeometrySerializer("triangle");

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $triangle -> setBorders(array(
            "a" => $a,
            "b" => $b,
            "c" => $c            
        ));
        $triangle -> setHeight($height);
        $triangle -> setRound($round);
        $triangle -> setCircumference();
        $triangle -> setSurface();
        
        return new JsonResponse ($serializer -> serialize($triangle, "json")); 
    }
}
