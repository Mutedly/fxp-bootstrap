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
class CallbackGetDataTransformer implements PreGetDataTransformerInterface, PostGetDataTransformerInterface
{
    /**
     * @var callable|null
     */
    protected $preCallback;

    /**
     * @var callable|null
     */
    protected $postCallback;

    /**
     * Constructor.
     *
     * @param callable|null $preCallback  The callback of pre get data
     * @param callable|null $postCallback The callback of post get data
     */
    public function __construct(callable $preCallback = null, callable $postCallback = null)
    {
        $this->preCallback = $preCallback;
        $this->postCallback = $postCallback;
    }

    /**
     * {@inheritdoc}
     */
    public function preGetData(DataSourceConfig $config)
    {
        if (null !== $this->preCallback) {
            call_user_func($this->preCallback);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function postGetData(DataSourceConfig $config)
    {
        if (null !== $this->postCallback) {
            call_user_func($this->postCallback);
        }
    }
}
