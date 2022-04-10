<?php

namespace App\Controller\Api\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Entity\User;
use App\Service\Auth\RegisterService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route("auth")]
class AuthContoller extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route("/register", name: "api_register", methods: ["POST"])]
    public function register(RegisterDTO $authDTO, RegisterService $service): Response
    {
        $service->register($authDTO);
        return new JsonResponse([], Response::HTTP_OK);
    }

    #[Route("/login", name: "api_login", methods: ["POST"])]
    public function login(#[CurrentUser] ?User $user): Response
    {
        return new JsonResponse([
            'token' => $user->getApiToken(),
        ], Response::HTTP_OK);
    }
}
