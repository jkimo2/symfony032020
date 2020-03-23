<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends AbstractController
{
    public const MILE_IN_KILOMETER = 1.609;
    public function hello()
    {
        $response = new Response();
        $response->setContent("Bonjour tout le monde");
        $response->headers->set('Content-Type',"html");
        $response->setStatusCode(Response::HTTP_PARTIAL_CONTENT);

        return $response;
    }
    public function hello2()
    {
        //dump("toto"); //retirer avant fusion git dans la master
        return new Response("<body><h1>Bonjour tout le monde</h1>hello 2</body>");
    }

    public function convertKm(int $kilometres)
    {
        $miles = $kilometres / self::MILE_IN_KILOMETER;

        return $this->json([
            'kilometers' => $kilometres,
            'miles'=> $miles
        ]);
    }

    public function convertMile(int $miles)
    {
        $kilometres = $miles * self::MILE_IN_KILOMETER;

        return $this->json([
            'kilometers' => $kilometres,
            'miles'=> $miles
        ]);
    }
}