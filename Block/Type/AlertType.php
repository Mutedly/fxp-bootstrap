<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Block\Type;

use Fxp\Component\Block\AbstractType;
use Fxp\Component\Block\BlockInterface;
use Fxp\Component\Block\BlockView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Alert Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class AlertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'style' => $options['style'],
            'dismissable' => $options['dismissable'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'style' => 'info',
            'dismissable' => false,
        ));

        $resolver->setAllowedTypes('style', 'string');
        $resolver->setAllowedTypes('dismissable', 'bool');

        $resolver->setAllowedValues('style', array('success', 'info', 'warning', 'danger'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'alert';
    }
}
