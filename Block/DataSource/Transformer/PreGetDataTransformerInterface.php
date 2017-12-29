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
interface PreGetDataTransformerInterface extends DataTransformerInterface
{
    /**
     * Action before getting the data.
     *
     * @param DataSourceConfig $config The data source config
     */
    public function preGetData(DataSourceConfig $config);
}
