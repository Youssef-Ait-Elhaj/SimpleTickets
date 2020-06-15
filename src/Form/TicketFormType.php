<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('priority', ChoiceType::class, [
                'multiple' => false,
                'choices' => [
                    'Very High' => 5,
                    'High' => 4,
                    'Medium' => 3,
                    'Low' => 2,
                    'Very Low' => 1
                ]
            ])
            ->add('body')
            ->add('assignmentDate')
//            ->add('technician')
            ->add('technician', EntityType::class, [
                'class' => User::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :role')
                        ->setParameter('role', '%"ROLE_TECHNICIAN"%');
                },
                'choice_label' => 'username'
            ])
//            ->add('customer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
