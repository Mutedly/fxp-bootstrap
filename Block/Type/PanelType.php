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
use Fxp\Component\Block\BlockBuilderInterface;
use Fxp\Component\Block\BlockInterface;
use Fxp\Component\Block\BlockView;
use Fxp\Component\Block\Exception\InvalidConfigurationException;
use Fxp\Component\Block\Util\BlockUtil;
use Fxp\Component\Block\Util\StringUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Panel Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class PanelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildBlock(BlockBuilderInterface $builder, array $options)
    {
        if (!empty($options['label'])) {
            $builder->add('header', PanelHeaderType::class, array());
            $builder->get('header')->add(null, HeadingType::class, array('size' => 4, 'label' => $options['label']));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(BlockInterface $child, BlockInterface $block, array $options)
    {
        if (BlockUtil::isBlockType($child, PanelHeaderType::class)) {
            if ($block->getAttribute('has_header')) {
                $msg = 'The panel block "%s" has already panel header. Removes the label option of the panel block.';
                throw new InvalidConfigurationException(sprintf($msg, StringUtil::fqcnToBlockPrefix(get_class($block->getConfig()->getType()->getInnerType()), true)));
            }

            $block->setAttribute('has_header', true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(BlockInterface $child, BlockInterface $block, array $options)
    {
        if (BlockUtil::isBlockType($child, PanelHeaderType::class)) {
            $block->setAttribute('has_header', false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'style' => $options['style'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        foreach ($view->children as $name => $child) {
            if (in_array('panel_header', $child->vars['block_prefixes'])) {
                $view->vars['block_header'] = $child;
                unset($view->children[$name]);
            } elseif (in_array('panel_footer', $child->vars['block_prefixes'])) {
                $view->vars['block_footer'] = $child;
                unset($view->children[$name]);
            }
        }

        if (!is_scalar($view->vars['value'])) {
            $view->vars['value'] = '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'style' => null,
        ));

        $resolver->setAllowedTypes('style', array('null', 'string'));

        $resolver->setAllowedValues('style', array(null, 'default', 'primary', 'success', 'info', 'warning', 'danger'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'panel';
    }
}
