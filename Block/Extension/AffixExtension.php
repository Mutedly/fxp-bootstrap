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
 * Affix Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class AffixExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $affix = $options['affix'];

        if (null !== $affix['offset_top']) {
            $attr = $options['attr'];

            foreach ($affix as $key => $value) {
                if (null !== $value) {
                    $attr['data-'.str_replace('_', '-', $key)] = $value;
                }
            }

            $view->vars = array_replace($view->vars, array(
                'attr' => $attr,
                'affix_id' => $view->vars['id'],
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'affix' => array(),
        ));

        $resolver->addAllowedTypes('affix', 'array');

        $resolver->setNormalizer('affix', function (Options $options, $value) {
            $affixResolver = new OptionsResolver();

            $affixResolver->setDefaults(array(
                'spy' => 'affix',
                'offset_top' => null,
                'offset_bottom' => null,
                'target' => null,
            ));

            $affixResolver->setAllowedTypes('spy', 'string');
            $affixResolver->setAllowedTypes('offset_top', array('null', 'int', 'string'));
            $affixResolver->setAllowedTypes('offset_bottom', array('null', 'int', 'string'));

            return $affixResolver->resolve($value);
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
