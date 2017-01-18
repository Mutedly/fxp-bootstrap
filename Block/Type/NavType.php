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
use Sonatra\Component\Block\BlockInterface;
use Sonatra\Component\Block\BlockView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Nav Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class NavType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'style' => $options['style'],
            'justifed' => $options['justifed'],
            'stacked' => $options['stacked'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        $active = false;
        $firstItem = null;

        foreach ($view->children as $name => $child) {
            if (!in_array('nav_item', $child->vars['block_prefixes'])) {
                continue;
            }

            if (!$child->vars['rendered']) {
                unset($view->children[$name]);
                continue;
            }

            if (null === $firstItem) {
                $firstItem = $name;
            }

            if ($options['selected'] === $name) {
                $child->vars['active'] = true;
            }

            if (isset($child->vars['active']) && $child->vars['active']) {
                $active = true;
                break;
            }
        }

        if (!$active && null !== $firstItem && $options['active_first']) {
            $view->children[$firstItem]->vars['active'] = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'style' => 'tabs',
            'justifed' => false,
            'stacked' => false,
            'active_first' => true,
            'selected' => null,
        ));

        $resolver->setAllowedTypes('style', array('null', 'string'));
        $resolver->setAllowedTypes('justifed', 'bool');
        $resolver->setAllowedTypes('active_first', 'bool');
        $resolver->setAllowedTypes('selected', array('null', 'string'));

        $resolver->setAllowedValues('style', array(null, 'tabs', 'pills'));

        $resolver->setNormalizer('stacked', function (Options $options, $value = null) {
            if ('tabs' === $options['style'] || null === $options['style']) {
                return false;
            }

            return $value;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nav';
    }
}
