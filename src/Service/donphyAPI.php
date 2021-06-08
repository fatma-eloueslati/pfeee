<?php

namespace App\Service;

use App\Repository\DonPhyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\DonPhy;
use Symfony\Component\HttpFoundation\Request;

class donphyAPI
{
    /**
     * @Route("/donphy/liste", name="donphy_liste", methods={"GET"})
     */
    public function liste(DonPhyRepository $donphyRepo)
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
            $entityManager->persist($event);
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
