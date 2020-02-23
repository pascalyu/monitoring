<?php

namespace App\Form;

use App\Entity\Website;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebsiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url',TextType::class,[
                "label"=>"URL du site web",
                "attr"=>["placeholder"=>"Entrez une URL valide"]
                ])
            ->add('description',TextType::class)
            ->add('name',TextType::class,[
                "label"=>"Nom du site",
                "attr"=>["placeholder"=>"Entrez un nom pour le site"]
                ])
            ->add("submit", SubmitType::class,["label"=>"Sauvegarder ce site"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Website::class,
        ]);
    }
}
