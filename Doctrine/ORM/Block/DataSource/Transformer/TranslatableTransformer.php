<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Bootstrap\Doctrine\ORM\Block\DataSource\Transformer;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Sonatra\Component\Bootstrap\Block\DataSource\DataSourceConfig;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TranslatableTransformer implements PreExecuteQueryTransformerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var bool
     */
    protected $hasTranslatable = false;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager The entity manager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;

        if ($this->em->getEventManager()->hasListeners('postLoad')) {
            foreach ($this->em->getEventManager()->getListeners('postLoad') as $listener) {
                if ('Gedmo\Translatable\TranslatableListener' === get_class($listener)) {
                    $this->hasTranslatable = true;
                    break;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preExecuteQuery(DataSourceConfig $config, Query $query)
    {
        $tkc = 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker';

        if ($this->hasTranslatable && class_exists($tkc) && false === $query->getHint(Query::HINT_CUSTOM_OUTPUT_WALKER)) {
            $query->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, $tkc);
            $query->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $config->getLocale());
        }
    }
}
