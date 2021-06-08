<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Event;

/**
 * @route("/api", name="api_")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/event/liste", name="liste", methods={"GET"})
     */
    public function liste(EventRepository $eventRepo)
    {
        //récupérer la liste des events

        $events = $eventRepo->findAll();
        // dump("peace");
        // die;

        //spécifier qu'on utilise un encodeur en json
        $encoders = [new JsonEncoder()];

        // on instancie le normaliseur pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        //on fait la conversion en json 
        //on instancie le convertisseur 
        $serializer = new Serializer($normalizers, $encoders);

        //on convertit en json 
        $jsonContent = $serializer->serialize($events, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        //on instancie la réponse 
        $response = new Response($jsonContent);

        //on ajoute l'entete HTTP 
        $response->headers->set('Content-Type', 'application/json');

        //on envoie la reponse 
        return $response;

        // 
    }
}
