<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\PhaseClient;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Age',
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone portable',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse de messagerie',
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Note personnelle',
            ])
            ->add('phase_client', EntityType::class, [
                'class'             => PhaseClient::class,
                'query_builder'     => function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                                ->orderBy('u.libelle');
                },
                'choice_label'      => 'libelle',
                'required'          => true,
                'placeholder'       => 'Choisir une catégorie',
            ])
            ->add('telephone_fixe', TextType::class, [
                'label' => 'Téléphone fixe',
            ])
            ->add('adressePostale', TextareaType::class, [
                'label' => 'Adresse postale',
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn-success float-right']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
