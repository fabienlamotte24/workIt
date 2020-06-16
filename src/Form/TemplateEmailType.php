<?php

namespace App\Form;

use App\Entity\TemplateEmail;
use App\Entity\CategorieEmail;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TemplateEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [ "label" => "Rédigez un titre pour votre template d'email : ", "required" => true, "attr" => ["class" => "form-control"] ] )
            ->add('subject', TextType::class, [ "label" => "Sujet : ", "required" => true, "attr" => ["class" => "form-control"] ] )
            ->add('body', TextareaType::class, [ "label" => "Contenu de votre email : ", "required" => true, "attr" => ["class" => "form-control", "rows" => 8] ])
            ->add('categorie', EntityType::class, [
                'class'         => CategorieEmail::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.libelle', 'ASC');
                },
                "label" => "Catégorie : ",
                'choice_label'  => 'libelle',
                "required"      => true, 
                "attr" => ["class" => "form-control"]
            ])
            ->add('save', SubmitType::class, ["label" => "Enregistrer ce template", "attr" => ["class" => "btn btn-success float-right"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TemplateEmail::class,
        ]);
    }
}
