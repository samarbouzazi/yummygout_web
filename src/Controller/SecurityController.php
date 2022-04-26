<?php

namespace App\Controller;


use App\Entity\BlockedWords;
use App\Entity\ReportUser;
use App\Entity\User;
use App\Repository\BlockedWordsRepository;
use App\Repository\ReportUserRepository;
use App\Repository\UserRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Variable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;


class SecurityController extends AbstractController
{

    private $githubClient;

    /**
     * @param $githubClient
     */
    public function __construct($githubClient)
    {
        $this->githubClient = $githubClient;
    }


    /**
     *
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
           return $this->redirectToRoute('homePage');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/connect/github", name="github_connect")
     */
    public function connect(UrlGeneratorInterface $generator )
    {    
        $url = $generator->generate('homePage',[],UrlGeneratorInterface::ABSOLUTE_URL);

        return new RedirectResponse("https://github.com/login/oauth/authorize?client_id=$this->githubClient&redirect_uri=".$url);

    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/userStatus/{bool}/{id}", name="isactive")
     */
    public function activeUser($id, $bool, UserRepository $repo)
    {
        if ($bool == 1)
            $boolean = true;
        else if ($bool == 0)
            $boolean = false;


        $em = $this->getDoctrine()->getManager();
        $user = $repo->findOneBy(array('id' => $id));
        $user->setActive($boolean);

        $em->flush($user);

        return new Response();;
    }


    /**
     * @Route("/badWord", name="badWord")
     */
    public function blockWord( BlockedWordsRepository $repo,  Request $request,TokenStorageInterface $tokenStorage )
    {
  $count =3;

        $content = $request->get('content');
        if ($content) {

            $blocked_words = $this->getDoctrine()->getRepository(BlockedWords::class)->findAll();

            foreach ($blocked_words as $blocked_word) {
                // if (preg_match('/\b'.$blocked_word->getWord().'\b/', $content)) {
               if (strpos($content, $blocked_word->getWord()) !== false) {
                    $notValid = true;

                     $em= $this->getDoctrine()->getManager();

                     $user = new ReportUser();
                     $user->setUser($this->getUser());
                     $em->persist($user);
                     $em->flush() ;

                     break;


                } else {
                    $notValid = false;

                }

            }
            if ($notValid) {
               // $reports = $this->getDoctrine()->getRepository(ReportUser::class)->findBy(['id'=>$this->getUser()->getId()],[]);


                $user = $this->getUser();
                $words = $this->getDoctrine()->getRepository(ReportUser::class)->findBy([
                    'user' => $user // you can pass the user id or a user object
                ]);                //$res = count($reports->getReportUsers());

                $reports = count($words);
                $rest= $count- $reports;

                if ($reports >= 3)
                {
                    $em= $this->getDoctrine()->getManager();

                    $user->setActive(false);



                    $token = new AnonymousToken('default', 'anon.');
                    $tokenStorage->setToken($token);
                    $request->getSession()->invalidate();

                    return new Response( 'Unfortunately your account is  blocked  !');

                }

                return new Response(' No bad Words please you have  &nbsp;' .$rest.   '&nbsp  attempts left next you will be blocked'  , 401);


            }

        }

        return new Response('Success', 200);
    }
//    use Symfony\Component\HttpFoundation\Request;
//    use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
//    use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
//    use Symfony\Component\Security\Core\Exception\AccessDeniedException;


    public function closeCurrentSession(TokenStorageInterface $tokenStorage, Request $request)
    {
        $token = new AnonymousToken('default', 'anon.');
        $tokenStorage->setToken($token);
        $request->getSession()->invalidate();
        throw new AccessDeniedException();

    }

}
