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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * List Group Item Heading Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ListGroupItemHeadingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'size' => 4,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return HeadingType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'list_group_item_heading';
    }
}
