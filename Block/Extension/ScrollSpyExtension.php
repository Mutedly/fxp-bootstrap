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
 * Scroll Spy Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ScrollSpyExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $scrollSpy = $options['scroll_spy'];

        if (null !== $scrollSpy['on']) {
            $scrollSpy['target'] = $view->vars['id'];

            $view->vars = array_replace($view->vars, [
                'scroll_spy' => $scrollSpy,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'scroll_spy' => [],
        ]);

        $resolver->addAllowedTypes('scroll_spy', 'array');

        $resolver->setNormalizer('scroll_spy', function (Options $options, $value) {
            $scrollSpyResolver = new OptionsResolver();

            $scrollSpyResolver->setDefaults([
                'spy' => 'scroll',
                'on' => null,
                'offset' => null,
            ]);

            $scrollSpyResolver->setAllowedTypes('spy', 'string');
            $scrollSpyResolver->setAllowedTypes('on', ['null', 'string']);
            $scrollSpyResolver->setAllowedTypes('offset', ['null', 'int']);

            return $scrollSpyResolver->resolve($value);
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
