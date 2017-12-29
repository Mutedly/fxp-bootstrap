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

use Fxp\Component\Block\Extension\Core\Type\FormType;

/**
 * Navbar Form Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class NavbarFormType extends AbstractNavbarItemType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return FormType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'navbar_form';
    }
}
