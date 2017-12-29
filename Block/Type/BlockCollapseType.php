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
 * Block Collapse Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class BlockCollapseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'collapsible' => $options['collapsible'],
            'collapsed' => $options['collapsed'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'collapsible' => true,
            'collapsed' => false,
            'render_id' => function (Options $options) {
                return $options['collapsible'];
            },
        ]);

        $resolver->addAllowedTypes('collapsible', 'bool');
        $resolver->addAllowedTypes('collapsed', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'block_collapse';
    }
}
