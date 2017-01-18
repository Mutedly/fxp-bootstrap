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
 * Block Collapse Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class BlockCollapseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'collapsible' => $options['collapsible'],
            'collapsed' => $options['collapsed'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'collapsible' => true,
            'collapsed' => false,
            'render_id' => function (Options $options) {
                return $options['collapsible'];
            },
        ));

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
