<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    
    /**
     * @Route("/api/v1/user/{id}", name="user-show")
     */
    public function show(Request $request, $id )
    {   
        //retireve user by id
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        
        return $this->json([
            'response'  => 200,
            'id'        => $user->getId(),
            'nom'       => $user->getNom(),
            'prenom'    => $user->getPrenom()
        ]);
    }
}
