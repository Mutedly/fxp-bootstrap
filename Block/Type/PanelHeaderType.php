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
 * Panel Header Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class PanelHeaderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildBlock(BlockBuilderInterface $builder, array $options)
    {
        if (!BlockUtil::isEmpty($options['label'])) {
            $builder->add('_heading', HeadingType::class, [
                'size' => 4,
                'label' => $options['label'],
            ]);
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
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'panel_header';
    }
}
