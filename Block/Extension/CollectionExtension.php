<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Bootstrap\Block\Extension;

use Sonatra\Component\Block\AbstractTypeExtension;
use Sonatra\Component\Block\BlockInterface;
use Sonatra\Component\Block\BlockView;
use Sonatra\Component\Block\Extension\Core\Type\CollectionType;

/**
 * Collection Block Extension.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class CollectionExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        if (null !== $view->parent) {
            $view->vars = array_replace($view->vars, array(
                'row' => $view->parent->vars['row'],
                'row_label' => $view->parent->vars['row_label'],
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $form, array $options)
    {
        foreach ($view->children as $child) {
            $child->vars['display_label'] = false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return CollectionType::class;
    }
}
