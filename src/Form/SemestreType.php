<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Form/SemestreType.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 24/11/2019 21:07

namespace App\Form;

use App\Entity\Annee;
use App\Entity\Diplome;
use App\Entity\Personnel;
use App\Entity\Ppn;
use App\Entity\Semestre;
use App\Form\Type\YesNoType;
use App\Repository\AnneeRepository;
use App\Repository\PersonnelRepository;
use App\Repository\PpnRepository;
use App\Repository\SemestreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SemestreType
 * @package App\Form
 */
class SemestreType extends AbstractType
{
    /** @var Diplome */
    protected $diplome;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->diplome = $options['diplome'];

        $builder
            ->add('libelle', TextType::class, [
                'label' => 'label.libelle'
            ])
            ->add('codeElement', TextType::class, [
                'label' => 'label.code_element'
            ])
            ->add('annee', EntityType::class, [
                'class'         => Annee::class,
                'required'      => true,
                'choice_label'  => 'libelle',
                'expanded'      => true,
                'query_builder' => function(AnneeRepository $anneeRepository) {
                    return $anneeRepository->findByDiplomeBuilder($this->diplome);
                },
                'label'         => 'label.annee'
            ])

            ->add('couleur', ColorType::class, [
                'label' => 'label.couleur'
            ])
            ->add('ordreAnnee', ChoiceType::class, [
                'label'              => 'label.ordre_annee',
                'choices'            => [1 => 1, 2 => 2],
                'expanded'           => true,
                'translation_domain' => 'form'
            ])
            ->add('moisDebut', ChoiceType::class, [
                'label'              => 'label.mois_debut',
                'choices'            => [
                    'Janvier'   => 1,
                    'Février'   => 2,
                    'Mars'      => 3,
                    'Avril'     => 4,
                    'Mai'       => 5,
                    'Juin'      => 6,
                    'Juillet'   => 7,
                    'Août'      => 8,
                    'Septembre' => 9,
                    'Octobre'   => 10,
                    'Novembre'  => 11,
                    'Décembre'  => 12
                ],
                'expanded'           => false,
                'translation_domain' => 'form'
            ])
            ->add('ordreLmd', ChoiceType::class, [
                'label'   => 'label.ordre_lmd',
                'choices' => range(0, 16)
            ])
            ->add(
                'actif',
                YesNoType::class,
                [
                    'label' => 'label.actif'
                ]
            )
            ->add('nbGroupesCm', ChoiceType::class, [
                'label'   => 'label.nbGroupesCm',
                'choices' => range(0, 10)
            ])
            ->add('nbGroupesTd', ChoiceType::class, [
                'label'   => 'label.nbGroupesTd',
                'choices' => range(0, 10)
            ])
            ->add('nbGroupesTP', ChoiceType::class, [
                'label'   => 'label.nbGroupesTP',
                'choices' => range(0, 20)
            ])
            ->add(
                'optMailReleve',
                YesNoType::class,
                [

                    'label' => 'label.opt_mail_releve'
                ]
            )
            ->add('optDestMailReleve', EntityType::class, [
                'class'         => Personnel::class,
                'choice_label'  => 'display',
                'label'         => 'label.opt_destinataire_mail_releve',
                'required'      => false,
                'query_builder' => static function(PersonnelRepository $personnelRepository) {
                    return $personnelRepository->findAllOrder();
                },
                'attr'          => ['data-live-search' => 'true', 'data-provide' => 'selectpicker'],
            ])
            ->add(
                'optEvaluationModifiable',
                YesNoType::class,
                [

                    'label' => 'label.opt_evaluation_modifiable'
                ]
            )
            ->add(
                'optMailModificationNote',
                YesNoType::class,
                [

                    'label' => 'label.opt_mail_modification_note'
                ]
            )
            ->add('optDestMailModifNote', EntityType::class, [
                'class'         => Personnel::class,
                'choice_label'  => 'display',
                'label'         => 'label.opt_destinataire_mail_modification_note',
                'required'      => false,
                'query_builder' => static function(PersonnelRepository $personnelRepository) {
                    return $personnelRepository->findAllOrder();
                },
                'attr'          => ['data-live-search' => 'true', 'data-provide' => 'selectpicker'],
            ])
            ->add(
                'optEvaluationVisible',
                YesNoType::class,
                [

                    'label' => 'label.opt_evaluation_visible'
                ]
            )
            ->add(
                'optPenaliteAbsence',
                YesNoType::class,
                [

                    'label' => 'label.opt_penalite_absence'
                ]
            )
            ->add(
                'optPointPenaliteAbsence',
                TextType::class,
                [
                    'label'    => 'label.opt_point_penalite_absence',
                    'required' => false,
                ]
            )
            ->add(
                'optMailAbsenceResp',
                YesNoType::class,
                [

                    'label' => 'label.opt_mail_absence_responsable'
                ]
            )
            ->add('optDestMailAbsenceResp', EntityType::class, [
                'class'         => Personnel::class,
                'choice_label'  => 'display',
                'label'         => 'label.opt_destinataire_mail_absence_responsable',
                'required'      => false,
                'query_builder' => static function(PersonnelRepository $personnelRepository) {
                    return $personnelRepository->findAllOrder();
                },
                'attr'          => ['data-live-search' => 'true', 'data-provide' => 'selectpicker'],
            ])
            ->add(
                'optMailAbsenceEtudiant',
                YesNoType::class,
                [

                    'label' => 'label.opt_mail_absence_etudiant'
                ]
            )
            ->add(
                'optPenaliteAbsence',
                YesNoType::class,
                [

                    'label' => 'label.opt_point_penalite_absence'
                ]
            )
            ->add('ppn_actif', EntityType::class, [
                'class'         => Ppn::class,
                'required'      => false,
                'choice_label'  => 'libelle',
                'query_builder' => function(PpnRepository $ppnRepository) {
                    return $ppnRepository->findByDiplomeBuilder($this->diplome);
                },
                'label'         => 'label.ppn_actif'
            ])
            ->add('precedent', EntityType::class, [
                'placeholder'   => 'Choisir le semestre',
                'class'         => Semestre::class,
                'required'      => false,
                'choice_label'  => 'display',
                'query_builder' => function(SemestreRepository $semestreRepository) {
                    return $semestreRepository->findByDiplomeBuilder($this->diplome);
                },
                'label'         => 'label.semestre_precedent'
            ])
            ->add('suivant', EntityType::class, [
                'placeholder'   => 'Choisir le semestre',
                'class'         => Semestre::class,
                'required'      => false,
                'choice_label'  => 'display',
                'query_builder' => function(SemestreRepository $semestreRepository) {
                    return $semestreRepository->findByDiplomeBuilder($this->diplome);
                },
                'label'         => 'label.semestre_suivant'
            ]);
        if ($this->diplome->isOptDilpomeDecale()) {
            $builder->add('decale', EntityType::class, [
                'placeholder'   => 'Choisir le semestre',
                'class'         => Semestre::class,
                'required'      => false,
                'choice_label'  => 'display',
                'query_builder' => function(SemestreRepository $semestreRepository) {
                    return $semestreRepository->findByDiplomeBuilder($this->diplome);
                },
                'label'         => 'label.semestre_decale'
            ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => Semestre::class,
            'diplome'            => null,
            'translation_domain' => 'form'

        ]);
    }
}
