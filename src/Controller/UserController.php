<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Controller/UserController.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 23/11/2019 09:14

namespace App\Controller;

use App\Entity\Constantes;
use App\Entity\Etudiant;
use App\Entity\Personnel;
use App\Form\EtudiantProfilType;
use App\Form\PersonnelProfilType;
use App\Repository\EtudiantRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/utilisateur")
 */
class UserController extends BaseController
{
    /**
     * @Route("/mon-profil/{onglet}", name="user_mon_profil")
     * @param string $onglet
     *
     * @return Response
     */
    public function monProfil($onglet = 'scolarite'): Response
    {
        return $this->render('user/profil.html.twig', [
            'user'      => $this->getConnectedUser(),
            'onglet'    => $onglet,
            'monprofil' => true
        ]);
    }

    /**
     * @Route("/{type}/{slug}/{onglet}", name="user_profil", options={"expose": true})
     * @param EtudiantRepository  $etudiantRepository
     * @param PersonnelRepository $personnelRepository
     * @param                     $type
     * @param                     $slug
     *
     * @param string              $onglet
     *
     * @return RedirectResponse|Response
     * @throws NonUniqueResultException
     */
    public function index(
        EtudiantRepository $etudiantRepository,
        PersonnelRepository $personnelRepository,
        $type,
        $slug,
        $onglet = 'timeline'
    ) {
        if ($type === 'personnel') {
            $user = $personnelRepository->findOneBySlug($slug);

            return $this->render('user/profil.html.twig', [
                'user'      => $user,
                'onglet'    => $onglet,
                'monprofil' => false
            ]);
        }

        if ($type === 'etudiant') {
            $user = $etudiantRepository->findOneBySlug($slug);

            return $this->render('user/profil.html.twig', [
                'user'      => $user,
                'onglet'    => $onglet,
                'monprofil' => false
            ]);
        }

        return $this->redirectToRoute('erreur_404');
    }


    /**
     * @Route("/settings", name="user_settings")
     * @param Request $request
     *
     * @return Response
     */
    public function settings(Request $request): Response
    {
        $user = $this->getConnectedUser();
        if ($user instanceof Personnel) {
            $form = $this->createForm(
                PersonnelProfilType::class,
                $user,
                [
                    'locale' => $request->getLocale(),
                    'attr'   => [
                        'data-provide' => 'validation'
                    ]
                ]
            );
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                //$this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'donnees.update.success.flash');
            }
        } elseif ($user instanceof Etudiant) {
            $form = $this->createForm(EtudiantProfilType::class, $user, [
                'attr' =>
                    ['data-provide' => 'validation']
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                //$this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'donnees.update.success.flash');
            }
        } else {
            return $this->redirectToRoute('erreur_404');
        }

        return $this->render('user/settings.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
