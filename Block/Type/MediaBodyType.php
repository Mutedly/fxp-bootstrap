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
use Fxp\Component\Block\Util\BlockUtil;

/**
 * Media Body Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MediaBodyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        foreach ($view->children as $child) {
            if (in_array('heading', $child->vars['block_prefixes'])) {
                BlockUtil::addAttributeClass($child, 'media-heading');
                $child->vars['size'] = 4;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'media_body';
    }
}
