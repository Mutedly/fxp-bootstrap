<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Block\Extension;

use Fxp\Component\Block\AbstractTypeExtension;
use Fxp\Component\Block\BlockInterface;
use Fxp\Component\Block\BlockView;
use Fxp\Component\Block\Extension\Core\Type\RepeatedType;
use Fxp\Component\Bootstrap\Block\Common\ConfigLayout;

/**
 * Repeated Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class RepeatedExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        ConfigLayout::buildView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        ConfigLayout::finishView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return RepeatedType::class;
    }
}
