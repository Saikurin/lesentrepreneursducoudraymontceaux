<?php

namespace App\Form;

use App\Entity\DemandeAdhesion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class AdhesionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_prenom', TextType::class, [
                'label' => 'NOM et Prénom(s)',
                'required' => true,
            ])
            ->add('raison_social', TextType::class, [
                'label' => 'Raison sociale de l\'adhérent',
                'required' => true,
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse complète',
                'required' => true,
            ])
            ->add('profession', TextType::class, [
                'label' => 'Profession',
                'required' => true,
            ])
            ->add('contact', TextType::class, [
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new Email(['message' => 'Veuillez saisir une adresse email valide']),
                ],
            ])
            ->add('accept_terms', CheckboxType::class, [
                'label' => "J'accepte les CGU et le règlement intérieur",
                'mapped' => false,  // Indique que ce champ n'est pas lié à l'entité DemandeAdhesion
                'required' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeAdhesion::class,
        ]);
    }
}
