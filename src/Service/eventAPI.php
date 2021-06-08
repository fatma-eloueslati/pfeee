<?php

namespace App\Service;

use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;

class eventAPI
{
    /**
     * @Route("/event/liste", name="liste", methods={"GET"})
     */
    public function liste(EventRepository $eventRepo)
    {
        //récupérer la liste des events

        $events = $eventRepo->findAll();

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
    }
    /**
     * @Route("/event/lire/{id}", name="event_lire", methods={"GET"})
     */
    public function getEvent(Event $event)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($event, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/event/ajout", name="event_ajout", methods={"POST"})
     */
    public function addEvent(Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if ($request->isXmlHttpRequest()) {
            // On instancie un nouvel article
            $event = new Event();

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On hydrate l'objet
            $event->setTitre($donnees->titre);
            $event->setDescription($donnees->descriptio,);
            $event->setDate($donnees->date);
            $event->setLocalisation($donnees->localisation);
            $event->setUrlphoto($donnees->urlphoto);
            $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(["id" => 1]);
            $event->setUser($user);

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', 201);
        }
        return new Response('Failed', 404);
    }

    /**
     * @Route("/event/editer/{id}", name="event_edit", methods={"PUT"})
     */
    public function editEvent(?Event $event, Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if ($request->isXmlHttpRequest()) {

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On initialise le code de réponse
            $code = 200;

            // Si l'event n'est pas trouvé
            if (!$event) {
                // On instancie un nouvel event
                $event = new Event();
                // On change le code de réponse
                $code = 201;
            }

            // On hydrate l'objet
            $event->setTitre($donnees->titre);
            $event->setDescription($donnees->description);
            $event->setDate($donnees->date);
            $event->setLocalisation($donnees->localisation);
            $event->setUrlphoto($donnees->urlphoto);
            $user = $this->getDoctrine()->getRepository(User::class)->find(1);
            $event->setUser($user);

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', $code);
        }
        return new Response('Failed', 404);
    }
    /**
     * @Route("/event/supprimer/{id}", name="event_supprime", methods={"DELETE"})
     */
    public function removeEvent(Event $event)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
        return new Response('ok');
    }
}
