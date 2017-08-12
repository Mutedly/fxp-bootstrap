<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Bootstrap\Block\DataSource\Transformer;

use Sonatra\Component\Bootstrap\Block\DataSource\DataSourceConfig;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface PrePaginateTransformerInterface extends DataTransformerInterface
{
    /**
     * Transform the list before the pagination.
     *
     * @param DataSourceConfig $config The data source config
     * @param object[]|array[] $rows   The object list
     *
     * @return object[]|array[]
     */
    public function prePaginate(DataSourceConfig $config, array $rows);
}
