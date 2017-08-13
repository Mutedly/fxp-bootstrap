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

use Doctrine\ORM\Query;
use Sonatra\Component\Block\Exception\InvalidArgumentException;
use Sonatra\Component\Bootstrap\Block\DataSource\DataSourceConfig;
use Sonatra\Component\DoctrineExtensions\ORM\Query\OrderByWalker;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class OrderByTransformer implements PreExecuteQueryTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function preExecuteQuery(DataSourceConfig $config, Query $query)
    {
        $sortColumns = $config->getSortColumns();

        if (count($sortColumns) > 0) {
            $customTreeWalkers = $query->getHint(Query::HINT_CUSTOM_TREE_WALKERS);

            if (!is_array($customTreeWalkers)) {
                $customTreeWalkers = array();
            }

            $customTreeWalkers[] = OrderByWalker::class;
            $query->setHint(Query::HINT_CUSTOM_TREE_WALKERS, $customTreeWalkers);

            $aliases = array();
            $fieldNames = array();
            $sorts = array();

            foreach ($sortColumns as $sortConfig) {
                if (!isset($sortConfig['name'])) {
                    throw new InvalidArgumentException("The 'name' property of sort_columns option must be present");
                }

                $field = $sortConfig['name'];
                $index = $config->getColumnIndex($field);
                $sort = isset($sortConfig['sort']) ? $sortConfig['sort'] : 'asc';
                $exp = explode('.', $index);

                if (1 === count($exp)) {
                    array_unshift($exp, false);
                }

                $aliases[] = $exp[0];
                $fieldNames[] = $exp[1];
                $sorts[] = $sort;
            }

            $query->setHint(OrderByWalker::HINT_SORT_ALIAS, $aliases);
            $query->setHint(OrderByWalker::HINT_SORT_FIELD, $fieldNames);
            $query->setHint(OrderByWalker::HINT_SORT_DIRECTION, $sorts);
        }
    }
}
