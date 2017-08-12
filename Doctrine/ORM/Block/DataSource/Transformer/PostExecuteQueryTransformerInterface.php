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

use Sonatra\Component\Bootstrap\Block\DataSource\DataSourceConfig;
use Sonatra\Component\Bootstrap\Block\DataSource\Transformer\DataTransformerInterface;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
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
