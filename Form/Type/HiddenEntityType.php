<?php

namespace Artprima\Bundle\FormsExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Artprima\Bundle\FormsExtraBundle\Form\DataTransformer\EntityToIdTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class HiddenEntityType
 *
 */
class HiddenEntityType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EntityToIdTransformer($this->objectManager, $options['class']);
        $builder->addViewTransformer($transformer);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['visible'] = $form->getConfig()->getOption('visible');
        $displayText = $form->getConfig()->getOption('display_text');
        if ($view->vars['visible'] && is_callable($displayText)) {
            $view->vars['attr']['data-display-text'] = call_user_func($displayText, $form);
        }
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(array('class'))
            ->setDefaults(array(
                'display_text' => null,
                'visible' => false,
                'invalid_message' => 'The entity does not exist.',
            ))
        ;
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return HiddenType::class;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'hidden_entity';
    }
}
