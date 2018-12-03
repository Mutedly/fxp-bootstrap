<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Block\Extension;

use Fxp\Component\Block\AbstractTypeExtension;
use Fxp\Component\Block\BlockInterface;
use Fxp\Component\Block\BlockView;
use Fxp\Component\Block\Util\BlockUtil;
use Fxp\Component\Bootstrap\Block\Type\HeadingType;
use Fxp\Component\Bootstrap\Block\Type\LinkType;
use Fxp\Component\Bootstrap\Block\Type\PanelGroupType;
use Fxp\Component\Bootstrap\Block\Type\PanelHeaderType;
use Fxp\Component\Bootstrap\Block\Type\PanelType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Panel Group Collapse Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class PanelGroupCollapseExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function addChild(BlockInterface $child, BlockInterface $block, array $options)
    {
        if ($options['collapsible'] && BlockUtil::isBlockType($child, PanelType::class)) {
            /* @var BlockInterface $subChild */
            foreach ($child->all() as $subChild) {
                if (BlockUtil::isBlockType($subChild, PanelHeaderType::class)) {
                    /* @var BlockInterface $subSubChild */
                    foreach ($subChild->all() as $subSubChild) {
                        if (BlockUtil::isBlockType($subSubChild, HeadingType::class)) {
                            foreach ($subSubChild->all() as $name => $subSubSubChild) {
                                $subSubChild->remove($name);
                            }

                            $subSubChild->add('panel_link', LinkType::class, [
                                'label' => $subSubChild->getOption('label'),
                                'src' => '#'.BlockUtil::createBlockId($child).'Collapse',
                                'attr' => ['data-toggle' => 'collapse', 'data-parent' => '#'.BlockUtil::createBlockId($block)],
                            ]);

                            $subSubChild->setOption('label', null);
                        }
                    }
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(BlockView $view, BlockInterface $block, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'collapsible' => $options['collapsible'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(BlockView $view, BlockInterface $block, array $options)
    {
        $first = null;

        if ($options['collapsible']) {
            foreach ($view->children as $name => $child) {
                $child->vars['group_collapse'] = true;

                if (null === $first) {
                    $first = $name;

                    if ($options['collapse_first']) {
                        $child->vars['group_collapse_in'] = true;
                    }
                }

                if (\in_array($view->vars['id'], $options['collapse_ins'])) {
                    $child->vars['group_collapse_in'] = true;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'collapsible' => false,
            'collapse_first' => false,
            'collapse_ins' => [],
            'render_id' => function (Options $options) {
                return $options['collapsible'];
            },
        ]);

        $resolver->addAllowedTypes('collapsible', 'bool');
        $resolver->addAllowedTypes('collapse_first', 'bool');
        $resolver->addAllowedTypes('collapse_ins', 'array');
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return PanelGroupType::class;
    }
}
