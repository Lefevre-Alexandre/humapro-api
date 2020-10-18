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
                'message'   => 'Parameter missing see doc',
                'response'  =>  404             
            ], 404);
        }

        //récupération de l'utilisateur celon les paramétres
        $user_available = $this->getDoctrine()
        ->getRepository(User::class)
        ->checkUserAvailable($email, $password);

        //vérifie si l'utilisateur est bien un utilisateur enregistrée
        if( $user_available ) {

            //cas ou token déjà existant
            if( $user_available->getAccessToken() ) {
                return $this->json([
                    'message'   => 'Access token retrieve with success',
                    'response'  => 200,
                    'token'     => $user_available->getAccessToken()              
                ], 200);
            }

            //cas ou ne dispose pas encore de token
            $user_available->setAccessToken( $this->getToken() );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist( $user_available );
            $entityManager->flush();

            return $this->json([
                'message'   => 'Access token created and retrieve with success',
                'response'  => 200,
                'token' => $user_available->getAccessToken()              
            ], 200);
        }

        //le cas échéant si l'utilisateur n'est pas un utilisateur enregistré.
        return $this->json([
            'message'   => 'User not authentified',
            'response'  => 404             
        ], 404);
    }

    /**
     * @Route("/api/v1/logout", name="logout")
     */
    public function logout(Request $request)
    {

        //récupération des paramétres requis
        $token = $request->headers->get('token');

        //récupération de l'utilisateur lier au token
        $user   = $this->checkToken( $token );

        //vérification que le token est bien attribuer à un utilisateur l'utilisateur
        if( $user ){
   
            //reset du token et token lifetime
            $user->setAccessToken(null);
            $user->setTokenLifetime(null);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist( $user );
            $entityManager->flush();

            return $this->json([
                'message'   => 'You get logged out',
                'response'  => 200      
            ], 200);
        }

        //cas échéant si le token n'est pas lier à aucun utilisateur
        return $this->json([
            'message'   => 'Bad request auth required see doc',
            'response'  => 404      
        ], 404);

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
