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
use Fxp\Component\Block\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Table Column Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TableColumnType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'index' => $options['index'],
            'formatter' => $options['formatter'],
            'formatter_options' => $options['formatter_options'],
            'empty_data' => $options['empty_data'],
        ]);
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

        $resolver->setDefaults([
            'index' => $index,
            'data_property_path' => null,
            'formatter' => TextType::class,
            'formatter_options' => [],
            'empty_data' => null,
            'cell_empty_data' => null,
            'override_options' => null,
        ]);

        $resolver->setAllowedTypes('formatter', ['null', 'string']);
        $resolver->setAllowedTypes('formatter_options', 'array');
        $resolver->setAllowedTypes('override_options', ['null', 'Closure']);

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
