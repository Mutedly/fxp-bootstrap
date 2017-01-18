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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Paragraph Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ParagraphType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'lead' => $options['lead'],
            'align' => $options['align'],
            'emphasis' => $options['emphasis'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'lead' => false,
            'align' => null,
            'emphasis' => null,
        ));

        $resolver->setAllowedTypes('lead', 'bool');
        $resolver->setAllowedTypes('align', array('null', 'string'));
        $resolver->setAllowedTypes('emphasis', array('null', 'string'));

        $resolver->setAllowedValues('align', array(null, 'left', 'center', 'right', 'justify'));
        $resolver->setAllowedValues('emphasis', array(null, 'muted', 'primary', 'success', 'info', 'warning', 'danger'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'paragraph';
    }
}
