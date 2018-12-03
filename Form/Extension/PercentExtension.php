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
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Percent Form Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class PercentExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $appendNormalizers = function (Options $options, $value) {
            if (null === $value) {
                $value = '%';
            }

            if ('' === $value) {
                $value = null;
            }

            return $value;
        };

        $resolver->setNormalizer('append', $appendNormalizers);
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes()
    {
        return [PercentType::class];
    }
}
