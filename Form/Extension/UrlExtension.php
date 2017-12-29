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

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Url Form Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class UrlExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'prepend' => function (Options $options) {
                return $options['default_protocol'].'://';
            },
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return UrlType::class;
    }
}
