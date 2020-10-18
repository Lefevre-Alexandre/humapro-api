Documentation api:


Ressource:

GET : /api/v1/auth
    - Description: Authentifie l'utilisateur pour la génération de token.
    - paramettre query:
        - email:
            type: string
            required: true
            description: Email de l'utilisateur.

        - password:
            type: string
            required: true
            description: Mot de passe utilisateur crypté hash BCRYPT
    - reponse: 
        - token : token pour auth
        - 200 : code 200


GET: /api/v1/me
    - Description: Retourne les informations utilisateur
    - paramettre header:
        - token:
            type: string
            required: true
            description: Token d'accès.
    - reponse:
        - id : id utilisateur   
        - nom : nom utilisateur
        - prenom : prenom utilisateur
        - 200 : code 200


POST: /api/v1/logout
    - Description: Déconnecte l'utilisateur.
    - paramettre header:
        - token:
            type: string
            required: true
            description: Token d'accès.
    - reponse: 
        - 200 : code 200
