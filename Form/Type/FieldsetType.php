<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Form\Type;

use Fxp\Component\Bootstrap\Form\Common\ConfigLayout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Fiedlset Form Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FieldsetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'legend' => $options['legend'],
            'legend_attr' => $options['legend_attr'],
            'compound' => true,
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        ConfigLayout::finishView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'legend' => null,
            'legend_attr' => [],
            'compound' => true,
            'inherit_data' => true,
        ]);

        $resolver->setAllowedTypes('legend', ['null', 'string']);
        $resolver->setAllowedTypes('legend_attr', ['array']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fieldset';
    }
}
