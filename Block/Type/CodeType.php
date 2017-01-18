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
use Sonatra\Component\Block\Extension\Core\Type\OutputType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Code Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class CodeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'inline' => $options['inline'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'inline' => true,
        ));

        $resolver->setAllowedTypes('inline', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return OutputType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'code';
    }
}
