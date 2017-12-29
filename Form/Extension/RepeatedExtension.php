<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Form\Extension;

use Fxp\Component\Bootstrap\Form\Common\ConfigLayout;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Repeated Form Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class RepeatedExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        ConfigLayout::finishView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return RepeatedType::class;
    }
}
