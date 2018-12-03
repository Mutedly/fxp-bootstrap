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
 * Carousel Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class CarouselType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $attr = $view->vars['attr'];
        $attr['data-ride'] = 'carousel';

        if (null !== $options['interval']) {
            $attr['data-interval'] = $options['interval'];
        }

        if (null !== $options['pause']) {
            $attr['data-pause'] = $options['pause'];
        }

        if (null !== $options['wrap']) {
            $attr['data-wrap'] = $options['wrap'];
        }

        if (null !== $options['slide']) {
            $attr['data-slide'] = $options['slide'];
        }

        if (null !== $options['slide_to']) {
            $attr['data-slide-to'] = $options['slide_to'];
        }

        $view->vars = array_replace($view->vars, [
            'attr' => $attr,
            'control' => $options['control'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        if ($options['indicator']) {
            $indicators = [];
            $hasActive = false;
            /* @var BlockView $firstChild */
            $firstChild = null;

            foreach ($view->children as $child) {
                if (\in_array('carousel_item', $child->vars['block_prefixes'])) {
                    $active = isset($child->vars['active']) && $child->vars['active'];
                    $indicators[] = $active;

                    if (null === $firstChild) {
                        $firstChild = $child;
                    }

                    if ($active) {
                        if ($hasActive) {
                            $child->vars['active'] = false;
                        }

                        $hasActive = true;
                    }
                }
            }

            if (!$hasActive && \count($indicators) > 0) {
                $indicators[0] = true;
                $firstChild->vars['active'] = true;
            }

            $view->vars = array_replace($view->vars, [
                'indicators' => $indicators,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'render_id' => true,
            'control' => true,
            'indicator' => true,
            'interval' => null,
            'pause' => null,
            'wrap' => null,
            'slide' => null,
            'slide_to' => null,
        ]);

        $resolver->setAllowedTypes('control', 'bool');
        $resolver->setAllowedTypes('indicator', 'bool');
        $resolver->setAllowedTypes('interval', ['null', 'int']);
        $resolver->setAllowedTypes('pause', ['null', 'string']);
        $resolver->setAllowedTypes('wrap', ['null', 'bool']);
        $resolver->setAllowedTypes('slide', ['null', 'string']);
        $resolver->setAllowedTypes('slide_to', ['null', 'int']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'carousel';
    }
}
