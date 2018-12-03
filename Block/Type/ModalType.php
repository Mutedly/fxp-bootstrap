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
 * Modal Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ModalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildBlock(BlockBuilderInterface $builder, array $options)
    {
        if (!empty($options['label'])) {
            $builder->add('header', ModalHeaderType::class, ['label' => $options['label']]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(BlockInterface $child, BlockInterface $block, array $options)
    {
        if (BlockUtil::isBlockType($child, ModalHeaderType::class)) {
            if ($block->getAttribute('has_header')) {
                $msg = 'The modal block "%s" has already modal header. Removes the label option of the modal block.';
                throw new InvalidConfigurationException(sprintf($msg, StringUtil::fqcnToBlockPrefix(\get_class($block->getConfig()->getType()->getInnerType()), true)));
            }

            $block->setAttribute('has_header', true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(BlockInterface $child, BlockInterface $block, array $options)
    {
        if (BlockUtil::isBlockType($child, ModalHeaderType::class)) {
            $block->setAttribute('has_header', false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'transition' => $options['transition'],
            'dialog_attr' => $options['dialog_attr'],
            'content_attr' => $options['content_attr'],
            'size' => $options['size'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        foreach ($view->children as $name => $child) {
            if (\in_array('modal_header', $child->vars['block_prefixes'])) {
                $view->vars['block_header'] = $child;
                unset($view->children[$name]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'render_id' => true,
            'transition' => null,
            'dialog_attr' => [],
            'content_attr' => [],
            'size' => null,
        ]);

        $resolver->setAllowedTypes('id', 'string');
        $resolver->setAllowedTypes('transition', ['null', 'string']);
        $resolver->setAllowedTypes('dialog_attr', 'array');
        $resolver->setAllowedTypes('content_attr', 'array');
        $resolver->setAllowedTypes('size', ['null', 'string']);

        $resolver->setAllowedValues('transition', [null, 'fade']);
        $resolver->setAllowedValues('size', [null, 'lg', 'sm']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'modal';
    }
}
