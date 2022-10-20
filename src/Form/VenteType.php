<?php

namespace App\Form;

use App\Entity\Vente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DatetimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VenteType extends AbstractType
{
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $builder
            /*->add('date', DatetimeType::class, [
                
                'data' => new \DateTime("now")])*/
            ->add('produit')
            ->add('quantity')
            ->add('vendor',HiddenType::class,array(
                                 'attr' => array(
                                    'value' => $user->getPseudo(),
                                 )) )
            ->add('prix_total',HiddenType::class, [
                    'required'   => false,
                    'empty_data' => '0',
                ])
            ->add('pu',HiddenType::class, [
                    'empty_data' => '0',
                ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
