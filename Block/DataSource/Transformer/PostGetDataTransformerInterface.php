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
interface PostGetDataTransformerInterface extends DataTransformerInterface
{
    /**
     * Transform the list after getting the data.
     *
     * @param DataSourceConfig $config The data source config
     */
    public function postGetData(DataSourceConfig $config);
}
