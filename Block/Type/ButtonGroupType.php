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
 * Button Group Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ButtonGroupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'size' => $options['size'],
            'vertical' => $options['vertical'],
            'justified' => $options['justified'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'size' => null,
            'vertical' => false,
            'justified' => false,
        ));

        $resolver->setAllowedTypes('size', array('null', 'string'));
        $resolver->setAllowedTypes('vertical', 'bool');
        $resolver->setAllowedTypes('justified', 'bool');

        $resolver->setAllowedValues('size', array(null, 'xs', 'sm', 'lg'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'button_group';
    }
}
