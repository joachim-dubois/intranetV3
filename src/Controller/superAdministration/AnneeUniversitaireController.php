<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Controller/superAdministration/AnneeUniversitaireController.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 25/11/2019 10:18

namespace App\Controller\superAdministration;

use App\Controller\BaseController;
use App\Entity\AnneeUniversitaire;
use App\Entity\Constantes;
use App\Form\AnneeUniversitaireType;
use App\MesClasses\MyExport;
use App\Repository\AnneeUniversitaireRepository;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administratif/annee-universitaire")
 */
class AnneeUniversitaireController extends BaseController
{
    /**
     * @Route("/", name="sa_annee_universitaire_index", methods={"GET"})
     * @param AnneeUniversitaireRepository $anneeUniversitaireRepository
     *
     * @return Response
     */
    public function index(AnneeUniversitaireRepository $anneeUniversitaireRepository): Response
    {
        return $this->render('super-administration/annee_universitaire/index.html.twig', [
            'annee_universitaires' => $anneeUniversitaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/annee-active/change/{annee}", name="sa_annee_universitaire_change_active", options={"expose":true})
     * @param Request            $request
     *
     * @param AnneeUniversitaire $annee
     *
     * @return Response
     */
    public function changeOption(Request $request, AnneeUniversitaire $annee): Response
    {
        $value = $request->request->get('value');
        $annee->setActive($value === 'true');
        $this->entityManager->flush();

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/export.{_format}", name="sa_annee_universitaire_export", methods="GET",
     *                             requirements={"_format"="csv|xlsx|pdf"})
     * @param MyExport                     $myExport
     * @param AnneeUniversitaireRepository $anneeUniversitaireRepository
     *
     * @param                              $_format
     *
     * @return Response
     * @throws Exception
     */
    public function export(
        MyExport $myExport,
        AnneeUniversitaireRepository $anneeUniversitaireRepository,
        $_format
    ): Response {
        $annee_universitaires = $anneeUniversitaireRepository->findAll();
        return $myExport->genereFichierGenerique(
            $_format,
            $annee_universitaires,
            'annee_universitaire',
            ['annee_universitaire'],
            ['libelle', 'annee', 'commentaire']
        );
    }

    /**
     * @Route("/new", name="sa_annee_universitaire_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $anneeUniversitaire = new AnneeUniversitaire();
        $form = $this->createForm(AnneeUniversitaireType::class, $anneeUniversitaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($anneeUniversitaire);
            $this->entityManager->flush();
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'annee_universitaire.add.success.flash');

            return $this->redirectToRoute('sa_annee_universitaire_index');
        }

        return $this->render('super-administration/annee_universitaire/new.html.twig', [
            'annee_universitaire' => $anneeUniversitaire,
            'form'                => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sa_annee_universitaire_show", methods={"GET"})
     * @param AnneeUniversitaire $anneeUniversitaire
     *
     * @return Response
     */
    public function show(AnneeUniversitaire $anneeUniversitaire): Response
    {
        return $this->render('super-administration/annee_universitaire/show.html.twig', [
            'annee_universitaire' => $anneeUniversitaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sa_annee_universitaire_edit", methods={"GET","POST"})
     * @param Request            $request
     * @param AnneeUniversitaire $anneeUniversitaire
     *
     * @return Response
     */
    public function edit(Request $request, AnneeUniversitaire $anneeUniversitaire): Response
    {
        $form = $this->createForm(AnneeUniversitaireType::class, $anneeUniversitaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'annee_universitaire.edit.success.flash');

            return $this->redirectToRoute('sa_annee_universitaire_index', [
                'id' => $anneeUniversitaire->getId(),
            ]);
        }

        return $this->render('super-administration/annee_universitaire/edit.html.twig', [
            'annee_universitaire' => $anneeUniversitaire,
            'form'                => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/duplicate", name="sa_annee_universitaire_duplicate", methods="GET|POST")
     * @param AnneeUniversitaire $annee_universitaire
     *
     * @return Response
     */
    public function duplicate(AnneeUniversitaire $annee_universitaire): Response
    {
        $newAnneeUniversitaire = clone $annee_universitaire;

        $this->entityManager->persist($newAnneeUniversitaire);
        $this->entityManager->flush();
        $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'annee_universitaire.duplicate.success.flash');

        return $this->redirectToRoute('sa_annee_universitaire_edit', ['id' => $newAnneeUniversitaire->getId()]);
    }

    /**
     * @Route("/{id}", name="sa_annee_universitaire_delete", methods="DELETE")
     * @param Request            $request
     * @param AnneeUniversitaire $annee_universitaire
     *
     * @return Response
     */
    public function delete(Request $request, AnneeUniversitaire $annee_universitaire): Response
    {
        $id = $annee_universitaire->getId();
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            if (count($annee_universitaire->getDepartements()) === 0 &&
                count($annee_universitaire->getDiplomes()) === 0 &&
                count($annee_universitaire->getScolarites()) === 0 &&
                count($annee_universitaire->getEvaluations()) === 0) {
                $this->entityManager->remove($annee_universitaire);
                $this->entityManager->flush();

                return $this->json($id, Response::HTTP_OK);
            }

            return $this->json('not_empty', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(false, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
