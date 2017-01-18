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

/**
 * Tab Content Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TabContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        $active = false;
        $firstItem = null;

        foreach ($view->children as $name => $child) {
            if (!in_array('tab_pane', $child->vars['block_prefixes'])) {
                continue;
            }

            if (null === $firstItem) {
                $firstItem = $name;
            }

            if (isset($child->vars['active']) && $child->vars['active']) {
                $active = true;
                break;
            }
        }

        if (!$active && null !== $firstItem) {
            $view->children[$firstItem]->vars['active'] = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tab_content';
    }
}
