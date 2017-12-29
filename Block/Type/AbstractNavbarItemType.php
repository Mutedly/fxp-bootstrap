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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Abstract Class for Navbar Item Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class AbstractNavbarItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        if ($options['align']) {
            BlockUtil::addAttributeClass($view, 'navbar-'.$options['align']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'chained_block' => true,
            'align' => null,
        ]);

        $resolver->setAllowedTypes('align', ['null', 'string']);

        $resolver->setAllowedValues('align', [null, 'left', 'right']);
    }
}
