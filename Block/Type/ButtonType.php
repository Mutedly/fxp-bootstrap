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
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Button Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ButtonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'tag' => $options['tag'],
            'disabled' => $options['disabled'],
            'src' => $options['src'],
            'style' => $options['style'],
            'size' => $options['size'],
            'block_level' => $options['block_level'],
            'prepend' => $options['prepend'],
            'append' => $options['append'],
            'caret' => $options['caret'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars['prepend_is_string'] = true;
        $view->vars['append_is_string'] = true;
        $view->vars['dropup'] = $options['dropup'];

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

        foreach ($view->children as $name => $child) {
            if (\in_array('dropdown', $child->vars['block_prefixes'])) {
                $child->vars['wrapper'] = false;
                $view->vars['dropdown'] = $child;
                unset($view->children[$name]);
            } elseif ('prepend' === $name) {
                $view->vars['prepend'] = $child;
                $view->vars['prepend_is_string'] = false;
                unset($view->children[$name]);
            } elseif ('append' === $name) {
                $view->vars['append'] = $child;
                $view->vars['append_is_string'] = false;
                unset($view->children[$name]);
            } elseif ('split' === $name) {
                $view->vars['split'] = $child;
                unset($view->children[$name]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'tag' => null,
            'label' => '',
            'disabled' => false,
            'src' => null,
            'style' => null,
            'size' => null,
            'block_level' => false,
            'prepend' => null,
            'append' => null,
            'dropup' => false,
            'caret' => true,
        ]);

        $resolver->setAllowedTypes('tag', ['null', 'string']);
        $resolver->setAllowedTypes('src', ['null', 'string']);
        $resolver->setAllowedTypes('style', ['null', 'string']);
        $resolver->setAllowedTypes('size', ['null', 'string']);
        $resolver->setAllowedTypes('block_level', 'bool');
        $resolver->setAllowedTypes('prepend', ['null', 'string']);
        $resolver->setAllowedTypes('append', ['null', 'string']);
        $resolver->setAllowedTypes('dropup', 'bool');
        $resolver->setAllowedTypes('caret', 'bool');

        $resolver->setAllowedValues('tag', [null, 'button', 'a']);
        $resolver->setAllowedValues('style', [null, 'default', 'primary', 'success', 'info', 'warning', 'danger', 'link']);
        $resolver->setAllowedValues('size', [null, 'xs', 'sm', 'lg']);

        $resolver->setNormalizer('src', function (Options $options, $value = null) {
            if (isset($options['data'])) {
                return $options['data'];
            }

            return $value;
        });
        $resolver->setNormalizer('tag', function (Options $options, $value = null) {
            if (null !== $value) {
                return $value;
            }

            if ((isset($options['data']) && null !== $options['data']) || (isset($options['src']) && null !== $options['src'])) {
                return 'a';
            }

            return 'button';
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'button';
    }
}
