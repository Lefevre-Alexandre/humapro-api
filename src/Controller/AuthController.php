<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class AuthController extends AbstractController
{
    
    /**
     * @Route("/api/v1/auth", name="token-auth")
     */
    public function auth()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }

    /**
     * @Route("/api/v1/logout", name="logout")
     */
    public function logout()
    {
        return $this->json([
            'message' => 'Welcome to logout!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }

    public function getToken()
    {

    }

    public function checkToken()
    {
        
    }

}
