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
use Sonatra\Component\Block\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

/**
 * Table Column Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TableColumnType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'index' => $options['index'],
            'formatter' => $options['formatter'],
            'formatter_options' => $options['formatter_options'],
            'empty_data' => $options['empty_data'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $index = function (Options $options, $value) {
            if (null === $value) {
                $value = $options['block_name'];
            }

            return $value;
        };

        $resolver->setDefaults(array(
            'index' => $index,
            'data_property_path' => null,
            'formatter' => TextType::class,
            'formatter_options' => array(),
            'empty_data' => null,
            'cell_empty_data' => null,
            'override_options' => null,
        ));

        $resolver->setAllowedTypes('formatter', array('null', 'string'));
        $resolver->setAllowedTypes('formatter_options', 'array');
        $resolver->setAllowedTypes('override_options', array('null', 'Closure'));

        $resolver->setNormalizer('formatter_options', function (Options $options, $value) {
            $value['empty_data'] = $options['empty_data'];
            $value['empty_message'] = $options['empty_message'];

            return $value;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'table_column';
    }
}
