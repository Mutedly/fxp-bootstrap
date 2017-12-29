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
 * Heading Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class HeadingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'size' => $options['size'],
            'secondary' => $options['secondary'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'size' => 1,
            'secondary' => null,
        ]);

        $resolver->setAllowedTypes('size', 'int');
        $resolver->setAllowedTypes('secondary', ['null', 'string']);

        $resolver->setAllowedValues('size', [1, 2, 3, 4, 5, 6]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'heading';
    }
}
