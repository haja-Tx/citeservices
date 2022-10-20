<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 14/01/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\Form\Type;

use JeckelLab\AdvancedTypes\Enum\EnumAbstract;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EnumChoiceType
 * @package JeckelLab\AdvancedTypes\Form\Type
 */
class EnumChoiceType extends ChoiceType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var string $className */
        $className = $options['enum_class_name'];
        if (! is_subclass_of($className, EnumAbstract::class)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid \'enum_class_name\' provided, expected instance of %s, but got %s',
                EnumAbstract::class,
                $className
            ));
        }
        $options['choices'] = call_user_func([$className, 'getEnumerators']);
        $options['empty_data'] = call_user_func([$className, 'byValue'], $options['empty_data']);
        parent::buildForm($builder, $options);
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setRequired(['enum_class_name'])
            ->setDefaults([
                'choice_label' => static function (EnumAbstract $choice) {
                    $value = $choice->getValue();
                    if (! is_string($value)) {
                        throw new InvalidArgumentException(sprintf(
                            'Unexpected value returned, expected string, but got %s',
                            gettype($value)
                        ));
                    }
                    return ucwords($value);
                },
                'choice_name' => 'name',
            ]);
    }
}
