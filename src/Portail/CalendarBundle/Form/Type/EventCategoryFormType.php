<?php

namespace BladeTester\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use BladeTester\CalendarBundle\Model\Color;

class EventCategoryFormType extends AbstractType {

    protected $dataClass;

    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('color', 'choice', array(
                'choices' => array(
                    Color::BLACK => 'Black',
                    Color::RED => 'Red',
                    Color::GREEN => 'Green',
                    Color::BLUE => 'Blue',
                    Color::YELLOW => 'Yellow',
                    Color::CYAN => 'Cyan',
                    Color::MAGENTA => 'Magenta',
                    Color::GRAY => 'Gray',
                    Color::WHITE => 'White',
                    ),
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'category';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass
        ));
    }
}