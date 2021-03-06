<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Resto;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class NewRestoController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        
    }
    /**
     * @Route("api/new/resto", name="new_resto", methods={"POST"})
     */
    public function restoNew(Request $request, EntityManagerInterface $manager,
    UserPasswordEncoderInterface $passwordEncode,RoleRepository $roleRepository, 
    UserRepository $userRepository,SerializerInterface $serializer)
    {
       $values = json_decode($request->getContent());
       $user = new User();
       $resto = new Resto();
       $role = $roleRepository->findOneBy(array('libelle' => 'ROLE_GERANT_RESTO'));
       $mail = $userRepository->findOneBy(array("email"=>$values->email));
       if($mail !== null)
        {
            $data = [
                'status' => 500,
                'message' => 'Cet adresse email existe déja . '];
    
            return new JsonResponse($data, 500);
        }

       if($mail === null) {
        #### Creation User ####
            $user->setEmail($values->email)
                    ->setPassword($passwordEncode->encodePassword($user, $values->password))
                    ->setRole($role)
                    ->setUsername($values->username)
                    ->setNomComplet($values->nomComplet)
                    ->setTelephone($values->telephone);
            $manager->persist($user);
        
        #### Creation Resto ####
            $userCreateur = $this->tokenStorage->getToken()->getUser();
            $resto->setNomResto($values->nomResto)
                  ->setDescription($values->description)
                  ->setUser($userCreateur)
                  ->setAdresse($values->adresse)
                  ->setImage($values->image);
            $manager->persist($resto);
            $manager->flush();
            $data = [
                'status' => 200,
                'message' => 'Nouveau resto creer avec succes. '];
    
            return new JsonResponse($data, 200);
       }
       
    }
}
