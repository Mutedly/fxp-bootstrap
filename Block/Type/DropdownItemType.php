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
use Sonatra\Component\Block\BlockInterface;
use Sonatra\Component\Block\BlockView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Dropdown Item Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DropdownItemType extends AbstractType
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
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        $prepends = array();
        $appends = array();

        foreach ($view->children as $name => $child) {
            if (in_array('dropdown_item_prepend', $child->vars['block_prefixes'])) {
                $prepends[$name] = $view->children[$name];
                unset($view->children[$name]);
            } elseif (in_array('dropdown_item_append', $child->vars['block_prefixes'])) {
                $appends[$name] = $view->children[$name];
                unset($view->children[$name]);
            }
        }

        $view->vars = array_replace($view->vars, array(
            'item_prepends' => $prepends,
            'item_appends' => $appends,
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
            'chained_block' => true,
        ));

        $resolver->setAllowedTypes('src', array('null', 'string'));
        $resolver->setAllowedTypes('link_attr', 'array');
        $resolver->setAllowedTypes('disabled', 'bool');

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
        return 'dropdown_item';
    }
}
