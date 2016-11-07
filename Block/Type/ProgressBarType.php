<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Bootstrap\Block\Type;

use Sonatra\Component\Block\AbstractType;
use Sonatra\Component\Block\BlockView;
use Sonatra\Component\Block\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Progress Bar Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ProgressBarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'min' => $options['min'],
            'max' => $options['max'],
            'style' => $options['style'],
            'striped' => $options['striped'],
            'animated' => $options['animated'],
            'stacked' => false,
        ));

        if (isset($view->parent) && in_array('progress_bar', $view->parent->vars['block_prefixes'])) {
            $view->vars = array_replace($view->vars, array(
                'stacked' => true,
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data' => 0,
            'min' => 0,
            'max' => 100,
            'style' => null,
            'striped' => false,
            'animated' => false,
            'label' => '%value%%',
        ));

        $resolver->setAllowedTypes('data', 'int');
        $resolver->setAllowedTypes('min', 'int');
        $resolver->setAllowedTypes('max', 'int');
        $resolver->setAllowedTypes('style', array('null', 'string'));
        $resolver->setAllowedTypes('striped', 'bool');
        $resolver->setAllowedTypes('animated', 'bool');

        $resolver->setAllowedValues('style', array(null, 'success', 'info', 'warning', 'danger'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'progress_bar';
    }
}
