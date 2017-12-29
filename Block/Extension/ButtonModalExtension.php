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
 * Button Modal Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ButtonModalExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        if (null !== $options['modal_id']) {
            $view->vars = array_replace($view->vars, [
                'attr' => array_replace($view->vars['attr'], [
                    'data-toggle' => 'modal',
                    'data-target' => sprintf('#%s', trim($options['modal_id'], '#')),
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
            'modal_id' => null,
        ]);

        $resolver->addAllowedTypes('modal_id', ['null', 'string']);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return ButtonType::class;
    }
}
