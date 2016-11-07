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
use Sonatra\Component\Block\BlockView;
use Sonatra\Component\Block\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Badge Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class BadgeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'align' => $options['align'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'align' => null,
        ));

        $resolver->setAllowedTypes('align', array('null', 'string'));

        $resolver->setAllowedValues('align', array(null, 'left', 'right'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'badge';
    }
}
