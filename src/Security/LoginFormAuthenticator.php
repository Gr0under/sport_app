<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security; 

use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface; //verification des tokens csrf 
use Symfony\Component\Security\Csrf\CsrfToken; 
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; //pour décoder les passwords

use App\Repository\UserRepository;

use Symfony\Component\Security\Http\Util\TargetPathTrait; //Redirection après la connexion vers une page consultée anonymement qui avait besoin d'un accès spécifique

use Symfony\Component\HttpFoundation\RedirectResponse; 

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $userRepository;
    private $routerInterface;  
    private $csrfTokenManager;  
    private $passwordEncoder; 

    use TargetPathTrait; //Appel au service targetPathTrait qui nous donne accès à ses méthodes.

    // On initialise le repo user dans le constructeur de la classe pour pouvoir effectuer des appels en DB depuis les autres méthodes de la classe. 
    public function __construct(UserRepository $userRepository, RouterInterface $routerInterface, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder )
    {
        $this->userRepository = $userRepository;
        $this->routerInterface  = $routerInterface ;
        $this->csrfTokenManager  = $csrfTokenManager  ;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        
        // Execute le contrôle uniquement si la route actuelle correspond à celle de app_login et qu'une méthode POST est passée dans la requête (si le formulaire est soumis)
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod('POST'); 
    }

    // Si la fonction supports ci dessus retourne true, getCredentials est déclenchée. Si supports return false, rien ne se passe et le site s'affiche normalement
    // Get credential doit récupérer les paramètres de la méthode Post appellée et les retourner dans un tableau qui sera automatiquement passé à la méthode getUser en paramètre $credentials
    public function getCredentials(Request $request)
    {
        // todo

        $credentials = [
            'email' => $request->request->get('email'), 
            'password' => $request->request->get('password'),
            'csrf_token' =>$request->request->get('_csrf_token'), //token ajouter manuellement dans le formulaire de connexion
        ];

        // Permet de stocker l'identifiant envoyé en post dans la session en cours afin de le retourner dans les vues tel que dans SecurityController avec $lastUsername = $authenticationUtils->getLastUsername();
        $request->getSession()->set(
            Security::LAST_USERNAME, 
            $credentials['email']
        ); 

        return $credentials;
    }

    //Cette méthode doit retourner un objet User basé sur les infos contenues dans credentials ou null s'il ne le trouve pas dans la DB. La requête en DB se fera via l'email fourni par un utilisateur dans le form de connexion. Le userRepo est initialisé dans la méthode __construct. 
    // Si un objet User est retourné, la méthode checkcredentials est déclenchée. Si null, une erreur est envoyée à l'utilisateur en cours de connexion et le processus s'arrête. Spécifier l'url de redirection dans getLoginUrl
    //Pour gérer les messages d'erreur, on doit passer par le système de traduction de Symfony pour modifier le message d'origine. Voir le fichier dans le dossier translation. 
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // Verification du jeton csrf. La clef authenticate a été spécifiée dans la vue twig et la valeur du jeton est récupérée via les credentials créés dans la méthode getCredentials ci-dessus
        $csrfToken = new CsrfToken('authenticate', $credentials['csrf_token']); 
        if(!$this->csrfTokenManager->isTokenValid($csrfToken))
        {
            throw new InvalidCsrfTokenException(); 
        }


        return $this->userRepository->findOneBy(['email' => $credentials['email']]);
    }

    // Cette méthode permet de faire le rapprochement entre les credentials et les infos de l'objet User. Exemple, vérifier que le password donné en credentials match avec celui de l'objet User précédemment retourné par la méthode getUser
    // Lorsque true est retourné, la méthode onAuthenticationSuccess est automatiquement déclenchée pour indiquer ce que l'on fait ensuite
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
       
        if($targetPath = $this->getTargetPath($request->getSession(), $providerKey))
        {
            return new RedirectResponse($targetPath); 

        }
        // Permet de retourner sur une URL de l'app comme redirectToRoute dans un Controller. Implémenter routerInterface dans le constructeur de la class pour pouvoir appeler les url par leur nom ('home dans le cas présent.')
        return new RedirectResponse($this->routerInterface->generate('home')); 
    }


    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
        // En cas de failure à authentification, cette url sera appellée et le user sera redirigé sur la page de connexion. 
        return $this->routerInterface->generate('app_login'); 
    }
}
