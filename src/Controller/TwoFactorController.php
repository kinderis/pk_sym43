<?php
namespace App\Controller;

use App\Entity\WebUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use App\Service\TwoFactorService;

class TwoFactorController extends AbstractController
{
    private $em;
    private $tokenStorage;
    private $twoFactorService;

    public function __construct(EntityManagerInterface $em,  TokenStorageInterface $storage, TwoFactorService $twoFactorService)

    {
        $this->em = $em;
        $this->tokenStorage = $storage;
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * @Route("/api/approveTwoFactorKey", methods={"POST"})
     * @return Response
     */

    public function approveTwoFactorKey (Request $request)
    {
        $token = $this->tokenStorage->getToken();
        /** @var WebUser $user */
        $user = $token->getUser();

        $response = $this->twoFactorService->approveKey($user, $request);

        $serializedEntity = $this->container->get('serializer')->serialize($response, 'json');
        return new Response($serializedEntity, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}