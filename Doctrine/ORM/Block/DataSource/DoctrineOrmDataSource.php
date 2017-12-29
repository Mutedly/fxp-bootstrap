<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Doctrine\ORM\Block\DataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Fxp\Component\Block\Exception\BadMethodCallException;
use Fxp\Component\Bootstrap\Block\DataSource\DataSource;
use Fxp\Component\Bootstrap\Doctrine\ORM\Block\DataSource\Transformer\OrderByTransformer;
use Fxp\Component\Bootstrap\Doctrine\ORM\Block\DataSource\Transformer\PostExecuteQueryTransformerInterface;
use Fxp\Component\Bootstrap\Doctrine\ORM\Block\DataSource\Transformer\PreExecuteQueryTransformerInterface;
use Fxp\Component\Bootstrap\Doctrine\ORM\Block\DataSource\Transformer\TranslatableTransformer;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class DoctrineOrmDataSource extends DataSource
{
    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * Constructor.
     *
     * @param EntityManager             $entityManager    The entity manager
     * @param string                    $rowId            The data fieldname for unique id row definition
     * @param PropertyAccessorInterface $propertyAccessor The property accessor
     */
    public function __construct(EntityManager $entityManager,
                                $rowId = null,
                                PropertyAccessorInterface $propertyAccessor = null)
    {
        parent::__construct($rowId, $propertyAccessor);

        $this->addDataTransformer(new TranslatableTransformer($entityManager));
        $this->addDataTransformer(new OrderByTransformer());
    }

    /**
     * Set query.
     *
     * @param Query|QueryBuilder $query
     *
     * @return DoctrineOrmDataSource
     */
    public function setQuery($query)
    {
        $this->cacheRows = null;
        $this->size = null;
        $this->paginator = new Paginator($query);

        return $this;
    }

    /**
     * Get query.
     *
     * @return Query
     */
    public function getQuery()
    {
        return null !== $this->paginator ? $this->paginator->getQuery() : null;
    }

    /**
     * {@inheritdoc}
     */
    public function setRows($rows)
    {
        throw new BadMethodCallException('The "setRows" method is not available. Uses "setQuery" method');
    }

    /**
     * {@inheritdoc}
     */
    public function getRows()
    {
        if (null !== $this->cacheRows) {
            return $this->cacheRows;
        }

        if (null === $this->paginator) {
            throw new BadMethodCallException('The query must be informed before the "getRows" method');
        }

        $this->cacheRows = array();
        $this->paginator->getQuery()
            ->setFirstResult($this->getStart() - 1)
            ->setMaxResults($this->getPageSize());

        $this->doPreGetData();
        $pagination = $this->paginator->getIterator()->getArrayCopy();
        $this->doPostGetData();
        $this->cacheRows = $this->paginateRows($pagination, $this->getStart());

        return $this->cacheRows;
    }

    /**
     * {@inheritdoc}
     */
    protected function calculateSize()
    {
        return (int) null !== $this->paginator ? $this->paginator->count() : 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function doPreGetData()
    {
        parent::doPreGetData();

        foreach ($this->dataTransformers as $dataTransformer) {
            if ($dataTransformer instanceof PreExecuteQueryTransformerInterface) {
                $dataTransformer->preExecuteQuery($this->config, $this->paginator->getQuery());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function doPostGetData()
    {
        parent::doPostGetData();

        foreach ($this->dataTransformers as $dataTransformer) {
            if ($dataTransformer instanceof PostExecuteQueryTransformerInterface) {
                $dataTransformer->postExecuteQuery($this->config);
            }
        }
    }
}
