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
 * Popover Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class PopoverExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $tip = $options['popover'];

        if (null !== $tip['content']) {
            $attr = $options['attr'];

            foreach ($tip as $key => $value) {
                if (null !== $value) {
                    $attr['data-'.$key] = $value;
                }
            }

            if (null !== $view->parent && in_array('button_group', $view->parent->vars['block_prefixes'])) {
                $attr['data-container'] = 'body';
            }

            $view->vars = array_replace($view->vars, [
                'attr' => $attr,
                'popover_id' => $view->vars['id'],
                'render_id' => true,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'popover' => [],
        ]);

        $resolver->addAllowedTypes('popover', 'array');

        $resolver->setNormalizer('popover', function (Options $options, $value) {
            $popoverResolver = new OptionsResolver();

            $popoverResolver->setDefaults([
                'toggle' => 'popover',
                'animation' => null,
                'html' => null,
                'placement' => null,
                'trigger' => null,
                'selector' => null,
                'title' => null,
                'content' => null,
                'delay' => null,
                'container' => null,
            ]);

            $popoverResolver->setAllowedTypes('toggle', 'string');
            $popoverResolver->setAllowedTypes('animation', ['null', 'bool']);
            $popoverResolver->setAllowedTypes('html', ['null', 'bool']);
            $popoverResolver->setAllowedTypes('placement', ['null', 'string']);
            $popoverResolver->setAllowedTypes('selector', ['null', 'string', 'bool']);
            $popoverResolver->setAllowedTypes('trigger', ['null', 'string']);
            $popoverResolver->setAllowedTypes('title', ['null', 'string', '\Twig_Markup']);
            $popoverResolver->setAllowedTypes('content', ['null', 'string', '\Twig_Markup']);
            $popoverResolver->setAllowedTypes('delay', ['null', 'int']);
            $popoverResolver->setAllowedTypes('container', ['null', 'string', 'bool']);

            $popoverResolver->setAllowedValues('placement', [null, 'top', 'bottom', 'left', 'right', 'auto', 'auto top', 'auto bottom', 'auto left', 'auto right']);

            return $popoverResolver->resolve($value);
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
