<?php

namespace App\Controller;

use App\Entity\WebUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use App\Service\TransactionService;

class TransactionController extends AbstractController
{
    private $em;
    private $tokenStorage;
    private $transactionService;

    public function __construct(EntityManagerInterface $em,  TokenStorageInterface $storage, TransactionService $transactionService)

    {
        $this->em = $em;
        $this->tokenStorage = $storage;
        $this->transactionService = $transactionService;
    }

    /**
     * @Route("/api/createTransaction", methods={"POST","HEAD"})
     */

    public function createTransaction ( Request $request )
    {
        $token = $this->tokenStorage->getToken();
        /** @var WebUser $user */
        $user = $token->getUser();

        $response = $this->transactionService->startTransaction( $user, $request );

        if ( $response['statusCode'] != Response::HTTP_OK ){
            $serializedEntity = $this->container->get('serializer')->serialize($response, 'json');
            return new Response($serializedEntity, $response['statusCode'], ['Content-Type' => 'application/json']);
        }

        unset($response['statusCode']);
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonObject = $serializer->serialize($response, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/authorizeTransaction", methods={"POST","HEAD"})
     */

    public function authorizeTransaction ( Request $request )
    {
        $token = $this->tokenStorage->getToken();
        /** @var WebUser $user */
        $user = $token->getUser();

        $response = $this->transactionService->authorizeTransaction( $user, $request );

        if ( $response['statusCode'] != Response::HTTP_OK ){
            $serializedEntity = $this->container->get('serializer')->serialize($response, 'json');
            return new Response($serializedEntity, $response['statusCode'], ['Content-Type' => 'application/json']);
        } else {
            unset($response['statusCode']);
            $serializedEntity = $this->container->get('serializer')->serialize($response, 'json');
            return new Response($serializedEntity, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        }
    }
}