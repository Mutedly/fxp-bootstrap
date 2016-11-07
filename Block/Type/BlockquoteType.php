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
use Sonatra\Component\Block\BlockView;
use Sonatra\Component\Block\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Blockquote Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class BlockquoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'reverse' => $options['reverse'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'reverse' => false,
        ));

        $resolver->setAllowedTypes('reverse', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blockquote';
    }
}
