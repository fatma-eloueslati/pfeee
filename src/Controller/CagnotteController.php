<?php

namespace App\Controller;

use App\Entity\Cagnotte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CagnotteController extends AbstractController
{
    /**
     * @Route("/cagnotte", name="cagnotte")
     */
    public function index(): Response
    {
        return $this->render('cagnotte/index.html.twig', [
            'controller_name' => 'CagnotteController',
        ]);
    }
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/cagnotte/add", name="add_cagnotte")
     * @param Request $request
     * @return JsonResponse
     */
    public function AddCagnotte(Request $request)
    {
        try {
            $cagnotte = new Cagnotte();
            $cagnotte->setTitre($request->get('Titre'));
            $cagnotte->setDescription($request->get('Description'));
            $cagnotte->setDeadline($request->get('deadline'));
            $cagnotte->setUrlphoto($request->get('urlphoto'));

            $user = $this->em->getRepository(User::class)->findOneBy(["id" => $request->request->get('user')]);
            $cagnotte->setUser($user);
            $this->em->persist($cagnotte);
            $this->em->flush();
            return new JsonResponse([
                'status' => 'Add success'
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'Unable to save new Cagnotte at this time.'
            ], JsonResponse::HTTP_FAILED_DEPENDENCY);
        }
    }

    /**
     * @return Response
     * @Route("/cagnotte/all", name="all_cagnotte")
     */
    public function getAllCagnottes()
    {

        $cagnotte = $this->em->getRepository(Cagnotte::class)->findAll();

        if (empty($cagnotte)) {

            $response = array(
                'code' => 1,
                'message' => 'Event not found',
                'error' => null,
                'result' => null
            );
            return new JsonResponse($response, 404);
        }
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent =  $serializer->serialize($cagnotte, 'json', [
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
     * @Route("/cagnotte/show/{id}",name="show_cagnotte")
     * @param Request $request
     * @param int $id
     * @return JsonResponse|Response
     */
    public function showCagnotte(Request $request, int $id)
    {
        $id = $request->request->get('id');

        $cagnotte = $this->em->getRepository(Cagnotte::class)->findOneBy(['id' => $id]);

        if (empty($cagnottet)) {
            return new JsonResponse(
                [
                    'status' => 'Cagnotte not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent =  $serializer->serialize($cagnotte, 'json', [
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
     * @Route("/cagnotte/update", name="update_cagnotte")
     * @param Request $request
     * @return JsonResponse
     */
    public function update_Event(Request $request)
    {
        $id = $request->get('id');

        $cagnotte = $this->em->getRepository(Event::class)->findOneBy(['id' => $id]);

        if (empty($cagnotte)) {
            return new JsonResponse(
                [
                    'status' => 'Event not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        try {
            $cagnotte->setTitre($request->get('TiTre'));
            $cagnotte->setDescription($request->get('Description'));
            $cagnotte->setDate($request->get('Date'));
            $cagnotte->setUrlphoto($request->get('urlphoto'));
            $this->em->persist($cagnotte);
            $this->em->flush();

            return new JsonResponse([
                'status' => 'Cagnotte update success'
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'status' => 'Unable to update Cagnotte at this time.',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
    }
    /**
     * @Route("/cagnotte/delete/{id}",name="delete_cagnotte")
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */

    public function deleteCagnotte(Request $request, int $id)
    {
        $id = $request->get('id');

        $cagnotte = $this->em->getRepository(Cagnotte::class)->findOneBy(['id' => $id]);

        if (empty($cagnotte)) {
            return new JsonResponse(
                [
                    'status' => 'Cagnotte not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }


        $this->em->remove($cagnotte);
        $this->em->flush();

        return new JsonResponse(
            [
                'status' => 'Cagnotte deleted '
            ],
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
