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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Dropdown Divider Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DropdownDividerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'chained_block' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dropdown_divider';
    }
}
