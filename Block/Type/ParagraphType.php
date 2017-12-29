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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Paragraph Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ParagraphType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'lead' => $options['lead'],
            'align' => $options['align'],
            'emphasis' => $options['emphasis'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'lead' => false,
            'align' => null,
            'emphasis' => null,
        ]);

        $resolver->setAllowedTypes('lead', 'bool');
        $resolver->setAllowedTypes('align', ['null', 'string']);
        $resolver->setAllowedTypes('emphasis', ['null', 'string']);

        $resolver->setAllowedValues('align', [null, 'left', 'center', 'right', 'justify']);
        $resolver->setAllowedValues('emphasis', [null, 'muted', 'primary', 'success', 'info', 'warning', 'danger']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'paragraph';
    }
}
