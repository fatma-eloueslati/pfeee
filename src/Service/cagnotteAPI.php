<?php

namespace App\Service;

use App\Repository\CagnotteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Cagnotte;
use Symfony\Component\HttpFoundation\Request;

/**
 * @route("/api", name="api_")
 */
class cagnotteAPI
{
    /**
     * @Route("/cagnotte/liste", name="liste", methods={"GET"})
     */
    public function liste(CagnotteRepository $cagnotteRepo)
    {
        //récupérer la liste des events

        $cagnotte = $cagnotteRepo->findAll();
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
}
