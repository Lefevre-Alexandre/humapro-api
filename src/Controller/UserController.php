<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    
    /**
     * @Route("/api/v1/me", name="user-show")
     */
    public function show(Request $request )
    {   
        $token = $request->headers->get('token');
        

        if( empty( $token ) ) {
            return $this->json([
                'message'   => 'Bad paramter auth missing see doc',
                'response'  => 404      
            ], 404);
        }

        //retireve user by id and token
        $user = $this->getDoctrine()->getRepository(User::class)->checkUserAvailableAndTokenAvailable($token );
        
        if( $user ) {
            return $this->json([
                'message'   => 'User retrieve with success',
                'response'  => 200,
                'id'        => $user->getId(),
                'nom'       => $user->getNom(),
                'prenom'    => $user->getPrenom()
            ], 200);
        }
        else{
            return $this->json([
                'message'   => 'Not Authorized',
                'response'  => 404      
            ], 404);
        }
        
    }
}
