<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Bootstrap\Block\Extension;

use Sonatra\Component\Block\AbstractTypeExtension;
use Sonatra\Component\Block\BlockInterface;
use Sonatra\Component\Block\BlockView;
use Sonatra\Component\Block\Extension\Core\Type\BlockType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

/**
 * Scroll Spy Block Extension.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
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

            $view->vars = array_replace($view->vars, array(
                'scroll_spy' => $scrollSpy,
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'scroll_spy' => array(),
        ));

        $resolver->addAllowedTypes('scroll_spy', 'array');

        $resolver->setNormalizer('scroll_spy', function (Options $options, $value) {
            $scrollSpyResolver = new OptionsResolver();

            $scrollSpyResolver->setDefaults(array(
                'spy' => 'scroll',
                'on' => null,
                'offset' => null,
            ));

            $scrollSpyResolver->setAllowedTypes('spy', 'string');
            $scrollSpyResolver->setAllowedTypes('on', array('null', 'string'));
            $scrollSpyResolver->setAllowedTypes('offset', array('null', 'int'));

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
