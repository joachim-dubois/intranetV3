<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Form/StageEtudiantType.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 23/11/2019 09:14

namespace App\Form;

use App\Entity\StageEtudiant;
use App\Form\Type\DateRangeType;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageEtudiantType extends AbstractType
{
    //formuliare Administrateur.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entreprise', EntrepriseType::class, ['label' => 'label.entreprise'])
            ->add('tuteur', ContactType::class, ['label' => 'label.tuteurEntreprise'])
            ->add('adresseStage', AdresseType::class, ['label' => 'Adresse du lieu où le stage sera effectué', 'help' => 'Cette adresse peut être différente du siège de l\'entreprise.'])

            ->add('serviceStageEntreprise', TextType::class, ['label' => 'label.serviceStageEntreprise'])
            ->add('sujetStage', TextareaType::class, ['label' => 'label.sujetStage'])
            ->add('activites', TextareaType::class, ['label' => 'label.activites'])

            ->add('dateRange', DateRangeType::class,
                ['label' => 'dateRange.periode.stage.etudiant', 'mapped' => false, 'required' => true])
            ->add('periodesInterruptions', TextareaType::class, ['label' => 'label.periodesInterruptions'])

            ->add('dureeHebdomadaire', TextType::class, ['label' => 'label.dureeHebdomadaire'])
            ->add(
                'commentaireDureeHebdomadaire',
                TextareaType::class,
                ['label' => 'label.commentaireDureeHebdomadaire', 'help' => 'help.commentaireDureeHebdomadaire']
            )
            ->add('dureeJoursStage', TextType::class, ['label' => 'label.dureeJoursStage'])
            ->add('amenagementStage', TextareaType::class, ['label' => 'label.amenagementStage'])

            ->add('gratification', YesNoType::class, ['label' => 'label.gratification'])
            ->add('gratificationMontant', TextType::class, ['label' => 'label.gratificationMontant'])
            ->add('gratificationPeriode', ChoiceType::class, ['label' => 'label.gratificationPeriode'])
            ->add('avantages', TextareaType::class, ['label' => 'label.avantages'])
            ->addEventListener(FormEvents::POST_SUBMIT, static function(FormEvent $event) {
                /** @var StageEtudiant $stageEtudiant */
                $stageEtudiant = $event->getData();
                $form = $event->getForm();
                $dateRange = $form->get('dateRange')->getData();
                $stageEtudiant->setDateDebutStage($dateRange['from_date']);
                $stageEtudiant->setDateFinStage($dateRange['to_date']);
            })
            ->addEventListener(FormEvents::PRE_SET_DATA, static function(FormEvent $event) {
                /** @var StageEtudiant $stageEtudiant */
                $stageEtudiant = $event->getData();
                $form = $event->getForm();
                $form->add('dateRange', DateRangeType::class, [
                    'label'     => 'dateRange.periode',
                    'mapped'    => false,
                    'date_data' => ['from' => $stageEtudiant->getDateDebutStage(), 'to' => $stageEtudiant->getDateFinStage()]
                ]);
            })
            ->add('dateRange', DateRangeType::class,
                ['label' => 'dateRange.periode.stage.etudiant', 'mapped' => false, 'required' => true])
            /*->add(
                'dateDebutStage',
                DateType::class,
                ['label' => 'label.dateDebutStage', 'help' => 'help.dateDebutStage', 'widget' => 'single_text']
            )
            ->add(
                'dateFinStage',
                DateType::class,
                ['label' => 'label.dateFinStage', 'help' => 'help.dateFinStage', 'widget' => 'single_text']
            )*/

            ->add(
                'dureeJoursStage',
                TextType::class,
                ['label' => 'label.dureeJoursStage', 'help' => 'help.dureeJoursStage']
            )
            ->addEventListener(FormEvents::POST_SUBMIT, static function(FormEvent $event) {
                /** @var StageEtudiant $stageEtudiant */
                $stageEtudiant = $event->getData();
                $form = $event->getForm();
                $dateRange = $form->get('dateRange')->getData();
                $stageEtudiant->setDateDebutStage($dateRange['from_date']);
                $stageEtudiant->setDateFinStage($dateRange['to_date']);
            })
            ->addEventListener(FormEvents::PRE_SET_DATA, static function(FormEvent $event) {
                /** @var StageEtudiant $stageEtudiant */
                $stageEtudiant = $event->getData();
                $form = $event->getForm();
                $form->add('dateRange', DateRangeType::class, [
                    'label'     => 'dateRange.periode',
                    'mapped'    => false,
                    'date_data' => [
                        'from' => $stageEtudiant->getDateDebutStage(),
                        'to'   => $stageEtudiant->getDateFinStage()
                    ]
                ]);
            });



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StageEtudiant::class,
            'translation_domain' => 'form'
        ]);
    }
}
