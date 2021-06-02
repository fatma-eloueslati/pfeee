<?php

namespace App\Controller;

use App\Entity\DonPhy;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;



class DonPhyController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/donphy", name="don_phy")
     */
    public function index(): Response
    {
        return $this->render('don_phy/index.html.twig', [
            'controller_name' => 'DonPhyController',
        ]);
    }
    /**
     * @Route("/add", name="add_DonPhy")
     * @param Request $request
     * @return JsonResponse
     */
    public function add_DonPhy(Request $request)
    {
        try {
            $donphy = new DonPhy();
            $donphy->setTitre($request->get('Titre'));
            $donphy->setDescription($request->get('Description'));
            $donphy->setNumTel($request->get('Numéro téléphone'));

            $donphy->setAdresse($request->get('Adresse'));
            $user = $this->em->getRepository(User::class)->findOneBy(["id" => $request->request->get('user')]);
            $donphy->setUser($user);
            $this->em->persist($donphy);
            $this->em->flush();
            return new JsonResponse([
                'status' => 'Add success'
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'Unable to save new DonPhy at this time.'
            ], JsonResponse::HTTP_FAILED_DEPENDENCY);
        }
    }

    /**
     * @return Response
     * @Route("/all", name="all_DonPhy")
     */
    public function getAll_DonPhy()
    {

        $donphy = $this->em->getRepository(DonPhy::class)->findAll();
        if (empty($donphy)) {

            $response = array(
                'code' => 1,
                'message' => 'DonPhy not found',
                'error' => null,
                'result' => null
            );
            return new JsonResponse($response, 404);
        }
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent =  $serializer->serialize($donphy, 'json', [
            ObjectNormalizer::IGNORED_ATTRIBUTES => [],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonContent, 200, array(
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ));
    }
    /**
     * @Route("/Show/{id}",name="show_DonPhy")
     * @param Request $request
     * @param int $id
     * @return JsonResponse|Response
     */
    public function show_DonPhy(Request $request, int $id)
    {
        $id = $request->request->get('id');

        $donphy = $this->em->getRepository(DonPhy::class)->findOneBy(['id' => $id]);

        if (empty($donphy)) {
            return new JsonResponse(
                [
                    'status' => 'DonPhy not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent =  $serializer->serialize($donphy, 'json', [
            ObjectNormalizer::IGNORED_ATTRIBUTES => [],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonContent, 200, array(
            'Content-Type' => 'application/json'
        ));
    }
    /**
     * @Route("/Update", name="update_DonPhy")
     * @param Request $request
     * @return JsonResponse
     */
    public function update_DonPhy(Request $request)
    {
        $id = $request->get('id');

        $donphy = $this->em->getRepository(DonPhy::class)->findOneBy(['id' => $id]);

        if (empty($donphy)) {
            return new JsonResponse(
                [
                    'status' => 'DonPhy not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        try {
            $donphy->setTitre($request->get('TiTre'));
            $donphy->setDescription($request->get('Description'));
            $donphy->setAdresse($request->get('Adresse'));
            $donphy->setUrlphoto($request->get('urlphoto'));
            $donphy->setNumTel($request->get('Numéro téléphone'));
            $this->em->persist($donphy);
            $this->em->flush();

            return new JsonResponse([
                'status' => 'DonPhy update success'
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'status' => 'Unable to update DonPhy at this time.',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @Route("/delete/{id}",name="delete_DonPhy")
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */

    public function delete_DonPhy(Request $request, int $id)
    {
        $id = $request->get('id');

        $donphy = $this->em->getRepository(DonPhy::class)->findOneBy(['id' => $id]);

        if (empty($donphy)) {
            return new JsonResponse(
                [
                    'status' => 'DonPhy not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }


        $this->em->remove($donphy);
        $this->em->flush();

        return new JsonResponse(
            [
                'status' => 'DonPhy deleted '
            ],
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
