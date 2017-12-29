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

/**
 * Navbar Button Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class NavbarButtonType extends AbstractNavbarItemType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ButtonType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'navbar_button';
    }
}
