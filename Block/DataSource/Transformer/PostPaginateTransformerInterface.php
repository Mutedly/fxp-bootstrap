<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Block\DataSource\Transformer;

use Fxp\Component\Bootstrap\Block\DataSource\DataSourceConfig;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface PostPaginateTransformerInterface extends DataTransformerInterface
{
    /**
     * Transform the list after the pagination.
     *
     * @param DataSourceConfig $config The data source config
     * @param object[]|array[] $rows   The object list
     *
     * @return object[]|array[]
     */
    public function postPaginate(DataSourceConfig $config, array $rows);
}
