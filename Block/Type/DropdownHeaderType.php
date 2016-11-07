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
 * Dropdown Header Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DropdownHeaderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'divider' => $options['divider'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'divider' => true,
            'chained_block' => true,
        ));

        $resolver->setAllowedTypes('divider', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dropdown_header';
    }
}
