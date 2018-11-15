<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Utils\GeometrySerializer;


class CircleController extends AbstractController
{
    /**
     * @Route(
     *  "/circle/{radius}/{round}", 
     *  name="circle", 
     *  methods={"GET"},
     *  defaults={"round" =2},
     *  requirements={ "radius" = "^[0-9]*$"})
     */
    public function index($radius,$round)
    {
        $circle = new GeometrySerializer("circle");

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $circle -> setRadius($radius);
        $circle -> setRound($round);
        $circle -> setSurface();
        $circle -> setCircumference();

        return new JsonResponse($serializer -> serialize($circle, "json")); 
        
    }
}
