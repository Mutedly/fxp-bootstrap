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
 * Dropdown Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class DropdownType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'wrapper' => $options['wrapper'],
            'wrapper_attr' => $options['wrapper_attr'],
            'align' => $options['align'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        /* @var BlockView $firstHeader */
        $firstHeader = null;
        /* @var string $lastDivider */
        $lastDivider = null;
        $hasItem = false;

        foreach ($view->children as $name => $child) {
            if (in_array('dropdown_divider', $child->vars['block_prefixes'])) {
                if (!$hasItem) {
                    unset($view->children[$name]);
                } else {
                    $hasItem = true;
                    $lastDivider = $name;
                }
            } elseif (in_array('dropdown_header', $child->vars['block_prefixes'])) {
                if (!$hasItem && null === $firstHeader) {
                    $firstHeader = $child;
                }

                $hasItem = true;
            } elseif (in_array('dropdown_item', $child->vars['block_prefixes'])) {
                $hasItem = true;
                $lastDivider = null;
            }
        }

        if (null !== $firstHeader) {
            $firstHeader->vars['divider'] = false;
        }

        if (null !== $lastDivider) {
            unset($view->children[$lastDivider]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'wrapper' => true,
            'wrapper_attr' => array(),
            'align' => null,
        ));

        $resolver->setAllowedTypes('wrapper', 'bool');
        $resolver->setAllowedTypes('wrapper_attr', 'array');
        $resolver->setAllowedTypes('align', array('null', 'string'));

        $resolver->setAllowedValues('align', array(null, 'left', 'right'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dropdown';
    }
}
