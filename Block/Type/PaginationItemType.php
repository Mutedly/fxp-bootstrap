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
use Fxp\Component\Block\BlockInterface;
use Fxp\Component\Block\BlockView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Pagination Item Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class PaginationItemType extends AbstractType
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
            'disabled' => $options['disabled'],
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
            'disabled' => false,
            'active' => false,
            'chained_block' => true,
        ));

        $resolver->setAllowedTypes('src', array('null', 'string'));
        $resolver->setAllowedTypes('link_attr', 'array');
        $resolver->setAllowedTypes('disabled', 'bool');
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
        return 'pagination_item';
    }
}
