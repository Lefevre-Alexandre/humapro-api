<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{
    
    /**
     * @Route("/api/v1/user/{id}", name="user-show")
     */
    public function show( $id )
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
            'user-id' => $id
        ]);
    }
}
