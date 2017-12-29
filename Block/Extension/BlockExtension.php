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
use Fxp\Component\Block\Extension\Core\Type\BlockType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Block Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class BlockExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'row_attr' => $options['row_attr'],
            'display_label' => $options['display_label'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'row_attr' => array(),
            'display_label' => true,
        ));

        $resolver->addAllowedTypes('row_attr', 'array');
        $resolver->addAllowedTypes('display_label', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return BlockType::class;
    }
}
