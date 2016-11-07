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
use Sonatra\Component\Bootstrap\Block\Common\ConfigLayout;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Fiedlset Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class FieldsetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        ConfigLayout::buildView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        ConfigLayout::finishView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fieldset';
    }
}
