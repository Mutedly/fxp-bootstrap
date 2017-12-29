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
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Tooltip Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TooltipExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $tip = $options['tooltip'];

        if (null !== $tip['title']) {
            $attr = $options['attr'];

            foreach ($tip as $key => $value) {
                if (null !== $value) {
                    $attr[('title' === $key ? $key : 'data-'.$key)] = $value;
                }
            }

            $view->vars = array_replace($view->vars, array(
                'attr' => $attr,
                'tooltip_id' => $view->vars['id'],
                'render_id' => true,
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'tooltip' => array(),
        ));

        $resolver->addAllowedTypes('tooltip', 'array');

        $resolver->setNormalizer('tooltip', function (Options $options, $value) {
            $tooltipResolver = new OptionsResolver();

            $tooltipResolver->setDefaults(array(
                'toggle' => 'tooltip',
                'animation' => null,
                'html' => null,
                'placement' => null,
                'selector' => null,
                'title' => null,
                'trigger' => null,
                'delay' => null,
                'container' => null,
            ));

            $tooltipResolver->setAllowedTypes('toggle', 'string');
            $tooltipResolver->setAllowedTypes('animation', array('null', 'bool'));
            $tooltipResolver->setAllowedTypes('html', array('null', 'bool'));
            $tooltipResolver->setAllowedTypes('placement', array('null', 'string'));
            $tooltipResolver->setAllowedTypes('selector', array('null', 'string', 'bool'));
            $tooltipResolver->setAllowedTypes('title', array('null', 'string', '\Twig_Markup'));
            $tooltipResolver->setAllowedTypes('trigger', array('null', 'string'));
            $tooltipResolver->setAllowedTypes('delay', array('null', 'int'));
            $tooltipResolver->setAllowedTypes('container', array('null', 'string', 'bool'));

            $tooltipResolver->setAllowedValues('placement', array(null, 'top', 'bottom', 'left', 'right', 'auto', 'auto top', 'auto bottom', 'auto left', 'auto right'));

            return $tooltipResolver->resolve($value);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return BlockType::class;
    }
}
