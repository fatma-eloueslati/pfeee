<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\CagnotteRepository;
use App\Repository\DonPhyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Event;
use App\Entity\DonPhy;
use App\Entity\Cagnotte;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/cagnotte/liste", name="liste", methods={"GET"})
     */
    public function listeCagnotte(CagnotteRepository $cagnotteRepo)
    {
        //récupérer la liste des events

        $cagnotte = $cagnotteRepo->findAll();

        return  new JsonResponse($cagnotte);
        dump($cagnotte);
        die;

        //spécifier qu'on utilise un encodeur en json
        $encoders = [new JsonEncoder()];

        // on instancie le normaliseur pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        //on fait la conversion en json 
        //on instancie le convertisseur 
        $serializer = new Serializer($normalizers, $encoders);

        //on convertit en json 
        $jsonContent = $serializer->serialize($cagnotte, 'json', [
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
     * @Route("/cagnotte/lire/{id}", name="cagnotte_lire", methods={"GET"})
     */
    public function getCagnotte(Cagnotte $cagnotte)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($cagnotte, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/cagnotte/ajout", name="cagnotte_ajout", methods={"POST"})
     */
    public function addCagnotte(Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if ($request->isXmlHttpRequest()) {
            // On instancie un nouvel article
            $cagnotte = new Cagnotte();

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On hydrate l'objet
            $cagnotte->setTitre($donnees->titre);
            $cagnotte->setDescription($donnees->descriptio,);
            $cagnotte->setDeadline($donnees->deadline);
            $cagnotte->setBeneficaire($donnees->beneficaire);
            $cagnotte->setObjectif($donnees->objectif);
            $cagnotte->setUrlphoto($donnees->urlphoto);
            $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(["id" => 1]);
            $cagnotte->setUser($user);

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cagnotte);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', 201);
        }
        return new Response('Failed', 404);
    }

    /**
     * @Route("/cagnotte/editer/{id}", name="cagnotte_edit", methods={"PUT"})
     */
    public function editCagnotte(?Cagnotte $cagnotte, Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if ($request->isXmlHttpRequest()) {

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On initialise le code de réponse
            $code = 200;

            // Si l'event n'est pas trouvé
            if (!$cagnotte) {
                // On instancie un nouvel event
                $cagnotte = new Cagnotte();
                // On change le code de réponse
                $code = 201;
            }

            // On hydrate l'objet
            $cagnotte->setTitre($donnees->titre);
            $cagnotte->setDescription($donnees->description);
            $cagnotte->setDeadline($donnees->deadline);
            $cagnotte->setBeneficaire($donnees->beneficaire);
            $cagnotte->setObjectif($donnees->objectif);
            $cagnotte->setUrlphoto($donnees->urlphoto);
            $user = $this->getDoctrine()->getRepository(User::class)->find(1);
            $cagnotte->setUser($user);

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cagnotte);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', $code);
        }
        return new Response('Failed', 404);
    }
    /**
     * @Route("/cagnotte/supprimer/{id}", name="cagnotte_supprime", methods={"DELETE"})
     */
    public function removeCagnotte(Cagnotte $cagnotte)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cagnotte);
        $entityManager->flush();
        return new Response('ok');
    }

    /**
     * @Route("/donphy/liste", name="donphy_liste", methods={"GET"})
     */
    public function listedonphy(DonPhyRepository $donphyRepo)
    {
        //récupérer la liste des events

        $donphy = $donphyRepo->findAll();
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
        $jsonContent = $serializer->serialize($donphy, 'json', [
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
     * @Route("/donphy/lire/{id}", name="event_lire", methods={"GET"})
     */
    public function getDonPhy(DonPhy $donphy)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($donphy, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/donphy/ajout", name="donphy_ajout", methods={"POST"})
     */
    public function addDonPhy(Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if ($request->isXmlHttpRequest()) {
            // On instancie un nouvel article
            $donphy = new DonPhy();

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On hydrate l'objet
            $donphy->setTitre($donnees->titre);
            $donphy->setDescription($donnees->descriptio,);
            $donphy->setNumTel($donnees->numtel);
            $donphy->setAdresse($donnees->adresse);
            $donphy->setUrlphoto($donnees->urlphoto);
            $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(["id" => 1]);
            $donphy->setUser($user);

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($donphy);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', 201);
        }
        return new Response('Failed', 404);
    }

    /**
     * @Route("/donphy/editer/{id}", name="donphy_edit", methods={"PUT"})
     */
    public function editDonPhy(?DonPhy $donphy, Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if ($request->isXmlHttpRequest()) {

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On initialise le code de réponse
            $code = 200;

            // Si l'event n'est pas trouvé
            if (!$donphy) {
                // On instancie un nouvel event
                $donphy = new DonPhy();
                // On change le code de réponse
                $code = 201;
            }

            // On hydrate l'objet
            $donphy->setTitre($donnees->titre);
            $donphy->setDescription($donnees->descriptio,);
            $donphy->setNumTel($donnees->numtel);
            $donphy->setAdresse($donnees->adresse);
            $donphy->setUrlphoto($donnees->urlphoto);
            $user = $this->getDoctrine()->getRepository(User::class)->find(1);
            $donphy->setUser($user);

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($donphy);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', $code);
        }
        return new Response('Failed', 404);
    }
    /**
     * @Route("/donphy/supprimer/{id}", name="donphy_supprime", methods={"DELETE"})
     */
    public function removeDonPhy(DonPhy $donphy)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($donphy);
        $entityManager->flush();
        return new Response('ok');
    }
}
