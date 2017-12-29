<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Form\Extension;

use Fxp\Component\Block\Util\BlockUtil;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Button Form Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ButtonExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (null !== $options['glyphicon']) {
            $view->vars['glyphicon'] = $options['glyphicon'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['block_level']) {
            BlockUtil::addAttributeClass($view, 'btn-block', true);
        }

        if (null !== $options['style']) {
            BlockUtil::addAttributeClass($view, 'btn-'.$options['style'], true);
        }

        if (null !== $options['size']) {
            BlockUtil::addAttributeClass($view, 'btn-'.$options['size'], true);
        }

        BlockUtil::addAttributeClass($view, 'btn', true);

        // layout
        if (null !== $view->parent && isset($view->parent->vars['layout'])) {
            $view->vars = array_replace($view->vars, [
                'layout' => $view->parent->vars['layout'],
                'layout_col_size' => $view->parent->vars['layout_col_size'],
                'layout_col_label' => $view->parent->vars['layout_col_label'],
                'layout_col_control' => $view->parent->vars['layout_col_control'],
            ]);

            if ('inline' === $view->vars['layout']) {
                $view->vars['display_label'] = false;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'style' => null,
            'size' => null,
            'block_level' => false,
            'glyphicon' => null,
        ]);

        $resolver->addAllowedTypes('style', ['null', 'string']);
        $resolver->addAllowedTypes('size', ['null', 'string']);
        $resolver->addAllowedTypes('block_level', 'bool');

        $resolver->addAllowedValues('style', [null, 'default', 'primary', 'success', 'info', 'warning', 'danger', 'link']);
        $resolver->addAllowedValues('size', [null, 'xs', 'sm', 'lg']);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return ButtonType::class;
    }
}
