<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends AbstractController
{
    
    /**
     * @Route("/api/v1/auth", name="token-auth")
     */
    public function auth(Request $request)
    {
        //récupération des paramétres
        $email      = $request->query->get('email');
        $password   = $request->query->get('password');
        
        //vérification des paramétres non vide
        if( empty( $email ) || empty( $password ) ) {
            return $this->json([
                'message' => 'Paramétres manquants'              
            ]);
        }

        //récupération de l'utilisateur celon les paramétres
        $user_available = $this->getDoctrine()
        ->getRepository(User::class)
        ->checkUserAvailable($email, $password);

        //vérifie si l'utilisateur est bien un utilisateur enregistrée
        if( $user_available ) {
            return $this->json([
                'message' => 'Token a retourner'              
            ]);
        }

        //le cas échéant si l'utilisateur n'est pas un utilisateur enregistré.
        return $this->json([
            'message' => 'Utilisateur non connu'              
        ]);
    }

    /**
     * @Route("/api/v1/logout", name="logout")
     */
    public function logout(Request $request)
    {
        //récupération des paramétres requis
        $token  = $request->query->get('token');
        //récupération de l'utilisateur lier au token
        $user   = $this->checkToken( $token );

        //vérification que le token est bien attribuer à un utilisateur l'utilisateur
        if( $user ){

            //reset du token
            //$user->setAccessToken('');

            return $this->json([
                'message' => 'You get logout'     
            ]);
        }

        //cas échéant si le token n'est pas lier à aucun utilisateur
        return $this->json([
            'message' => 'No access logout'     
        ]);

    }

    /**
     * Génére un token pour les demande de token
     */
    public function getToken()
    {
        
        $token_random = bin2hex( openssl_random_pseudo_bytes(16) );

        //vérification que le token n'est pas déjà attribuer
        while( $this->checkToken( $token_random ) ){
            $token_random = bin2hex( openssl_random_pseudo_bytes(16) );
        }

        return $token_random;
  
    }

    /**
     * Vérifie si le token est déjà attribuer à un utilisateur
     */
    public function checkToken( $token )
    {
        
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findUserWithToken($token);
        
            return $user;
    }

}
