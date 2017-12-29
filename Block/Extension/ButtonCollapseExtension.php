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
use Fxp\Component\Bootstrap\Block\Type\ButtonType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Button Collapse Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ButtonCollapseExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        if (null !== $options['collapse_id']) {
            $view->vars = array_replace($view->vars, [
                'attr' => array_replace($view->vars['attr'], [
                    'data-toggle' => 'collapse',
                    'data-target' => sprintf('#%s', trim($options['collapse_id'], '#')),
                ]),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'collapse_id' => null,
        ]);

        $resolver->addAllowedTypes('collapse_id', ['null', 'string']);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return ButtonType::class;
    }
}
