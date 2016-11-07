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
use Symfony\Component\OptionsResolver\Options;

/**
 * Breadcrumb Item Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class BreadcrumbItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $linkAttr = $options['link_attr'];

        if (null !== $options['src']) {
            $linkAttr['href'] = $options['src'];
        }

        $view->vars = array_replace($view->vars, array(
            'link_attr' => $linkAttr,
            'active' => $options['active'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'src' => '#',
            'link_attr' => array(),
            'active' => false,
        ));

        $resolver->setAllowedTypes('src', array('null', 'string'));
        $resolver->setAllowedTypes('link_attr', 'array');
        $resolver->setAllowedTypes('active', 'bool');

        $resolver->setNormalizer('src', function (Options $options, $value = null) {
            if (isset($options['data'])) {
                return $options['data'];
            }

            return $value;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'breadcrumb_item';
    }
}
