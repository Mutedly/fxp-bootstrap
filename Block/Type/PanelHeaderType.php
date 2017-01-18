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
use Sonatra\Component\Block\BlockBuilderInterface;
use Sonatra\Component\Block\BlockInterface;
use Sonatra\Component\Block\BlockView;
use Sonatra\Component\Block\Exception\InvalidConfigurationException;
use Sonatra\Component\Block\Util\BlockUtil;
use Sonatra\Component\Block\Util\StringUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Panel Header Block Type.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class PanelHeaderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildBlock(BlockBuilderInterface $builder, array $options)
    {
        if (!BlockUtil::isEmpty($options['label'])) {
            $builder->add('_heading', HeadingType::class, array(
                'size' => 4,
                'label' => $options['label'],
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(BlockInterface $child, BlockInterface $block, array $options)
    {
        if (BlockUtil::isBlockType($child, HeadingType::class)) {
            if ($block->has('_heading')) {
                $msg = 'The panel header block "%s" has already panel title. Removes the label option of the panel header block.';
                throw new InvalidConfigurationException(sprintf($msg, StringUtil::fqcnToBlockPrefix(get_class($block->getConfig()->getType()->getInnerType()), true)));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        foreach ($view->children as $name => $child) {
            if (in_array('heading', $child->vars['block_prefixes'])) {
                BlockUtil::addAttributeClass($child, 'panel-title');

                $view->vars['panel_heading'] = $child;
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
            'inherit_data' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'panel_header';
    }
}
