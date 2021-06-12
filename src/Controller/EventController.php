<?php

namespace App\Controller;


use App\Entity\Event;
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

class EventController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/event", name="event")
     */
    public function index(): Response
    {
        $test = "test";
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController', 'aaa' => $test
        ]);
    }

    /**
     * @Route("/event/add", name="add_Event")
     * @param Request $request
     * @return JsonResponse
     */
    public function AddEvent(Request $request)
    {
        try {
            $event = new Event();
            $event->setTitre($request->get('Titre'));
            $event->setDescription($request->get('Description'));
            $event->setDate($request->get('date'));
            $event->setUrlphoto($request->get('urlphoto'));
            $event->setLocalisation($request->get('Localisation'));
            $user = $this->em->getRepository(User::class)->findOneBy(["id" => $request->request->get('user')]);
            $event->setUser($user);
            $this->em->persist($event);
            $this->em->flush();
            return new JsonResponse([
                'status' => 'Add success'
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'Unable to save new Event at this time.'
            ], JsonResponse::HTTP_FAILED_DEPENDENCY);
        }
    }

    /**
     * @return Response
     * @Route("/event/all", name="all_Event")
     */
    public function getAllEvents()
    {

        $event = $this->em->getRepository(Event::class)->findAll();

        if (empty($event)) {

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
        $jsonContent =  $serializer->serialize($event, 'json', [
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
     * @Route("/event/show/{id}",name="show_Event")
     * @param Request $request
     * @param int $id
     * @return JsonResponse|Response
     */
    public function showEvent(Request $request, int $id)
    {
        $id = $request->request->get('id');

        $event = $this->em->getRepository(Event::class)->findOneBy(['id' => $id]);

        if (empty($event)) {
            return new JsonResponse(
                [
                    'status' => 'Event not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent =  $serializer->serialize($event, 'json', [
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
     * @Route("/event/update", name="update_Event")
     * @param Request $request
     * @return JsonResponse
     */
    public function updateEvent(Request $request)
    {
        $id = $request->get('id');

        $event = $this->em->getRepository(Event::class)->findOneBy(['id' => $id]);

        if (empty($event)) {
            return new JsonResponse(
                [
                    'status' => 'Event not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        try {
            $event->setTitre($request->get('TiTre'));
            $event->setDescription($request->get('Description'));
            $event->setDate($request->get('Date'));
            $event->setUrlphoto($request->get('urlphoto'));
            $this->em->persist($event);
            $this->em->flush();

            return new JsonResponse([
                'status' => 'Event update success'
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'status' => 'Unable to update  Event at this time.',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
    }
    /**
     * @Route("/event/delete/{id}",name="delete_Event")
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */

    public function deleteEvent(Request $request, int $id)
    {
        $id = $request->get('id');

        $event = $this->em->getRepository(Event::class)->findOneBy(['id' => $id]);

        if (empty($event)) {
            return new JsonResponse(
                [
                    'status' => 'Event not found',
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }


        $this->em->remove($event);
        $this->em->flush();

        return new JsonResponse(
            [
                'status' => 'Event deleted '
            ],
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
