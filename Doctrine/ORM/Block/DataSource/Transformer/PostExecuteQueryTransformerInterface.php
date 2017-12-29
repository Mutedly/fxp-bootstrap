<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Doctrine\ORM\Block\DataSource\Transformer;

use Fxp\Component\Bootstrap\Block\DataSource\DataSourceConfig;
use Fxp\Component\Bootstrap\Block\DataSource\Transformer\DataTransformerInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface PostExecuteQueryTransformerInterface extends DataTransformerInterface
{
    /**
     * Action after executing query.
     *
     * @param DataSourceConfig $config The data source config
     */
    public function postExecuteQuery(DataSourceConfig $config);
}
