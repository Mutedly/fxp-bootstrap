<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Bootstrap\Block\DataSource;

use Sonatra\Component\Block\BlockBuilderInterface;
use Sonatra\Component\Block\BlockInterface;
use Sonatra\Component\Block\BlockRendererInterface;
use Sonatra\Component\Block\BlockView;
use Sonatra\Component\Block\Exception\InvalidConfigurationException;
use Sonatra\Component\Block\Extension\Core\Type\TwigType;
use Sonatra\Component\Bootstrap\Block\DataSource\Transformer\DataTransformerInterface;
use Sonatra\Component\Bootstrap\Block\DataSource\Transformer\PostGetDataTransformerInterface;
use Sonatra\Component\Bootstrap\Block\DataSource\Transformer\PostPaginateTransformerInterface;
use Sonatra\Component\Bootstrap\Block\DataSource\Transformer\PreGetDataTransformerInterface;
use Sonatra\Component\Bootstrap\Block\DataSource\Transformer\PrePaginateTransformerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DataSource implements DataSourceInterface
{
    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    /**
     * @var DataSourceConfig
     */
    protected $config;

    /**
     * @var BlockRendererInterface
     */
    protected $renderer;

    /**
     * @var BlockView
     */
    protected $tableView;

    /**
     * @var array
     */
    protected $rows = array();

    /**
     * @var string
     */
    protected $rowId;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var int
     */
    protected $pageSize = 0;

    /**
     * @var int
     */
    protected $pageSizeMax = 0;

    /**
     * @var int
     */
    protected $pageNumber = 1;

    /**
     * @var DataTransformerInterface[]
     */
    protected $dataTransformers = array();

    /**
     * @var array
     */
    protected $cacheRows;

    /**
     * Constructor.
     *
     * @param string                    $rowId            The data fieldname for unique id row definition
     * @param PropertyAccessorInterface $propertyAccessor The property accessor
     */
    public function __construct($rowId = null, PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
        $this->config = new DataSourceConfig();
        $this->rowId = $rowId;
    }

    /**
     * {@inheritdoc}
     */
    public function addDataTransformer(DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformers[] = $dataTransformer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRenderer(BlockRendererInterface $renderer)
    {
        $this->renderer = $renderer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTableView(BlockView $view)
    {
        $this->tableView = $view;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTableView()
    {
        return $this->tableView;
    }

    /**
     * {@inheritdoc}
     */
    public function setColumns(array $columns)
    {
        $this->cacheRows = null;
        $this->config->setColumns($columns);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addColumn(BlockInterface $column, $index = null)
    {
        $this->cacheRows = null;
        $this->config->addColumn($column, $index);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeColumn($index)
    {
        $this->cacheRows = null;
        $this->config->removeColumn($index);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return $this->config->getColumns();
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale = null)
    {
        $this->cacheRows = null;
        $this->config->setLocale($locale);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->config->getLocale();
    }

    /**
     * {@inheritdoc}
     */
    public function setRows($rows)
    {
        $this->cacheRows = null;
        $this->size = null;
        $this->rows = $rows;
        $this->pageNumber = 1;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRows()
    {
        if (null !== $this->cacheRows) {
            return $this->cacheRows;
        }

        $this->cacheRows = array();
        $startTo = ($this->getPageNumber() - 1) * $this->getPageSize();
        $endTo = $this->getPageSize();

        if (0 === $startTo && 0 === $endTo) {
            $endTo = $this->getSize();
        }

        $this->doPreGetData();
        $pagination = array_slice($this->rows, $startTo, $endTo);
        $this->doPostGetData();
        $this->cacheRows = $this->paginateRows($pagination, $this->getStart());

        return $this->cacheRows;
    }

    /**
     * {@inheritdoc}
     */
    public function getStart()
    {
        return ($this->getPageNumber() - 1) * $this->getPageSize() + 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnd()
    {
        return 0 === $this->getPageSize()
            ? $this->getSize()
            : min($this->getSize(), ($this->getPageSize() * $this->getPageNumber()));
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        if (null === $this->size) {
            $this->size = $this->calculateSize();
        }

        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageSize($size)
    {
        $this->cacheRows = null;
        $this->pageSize = 0 === $this->getPageSizeMax() ? $size : min($size, $this->getPageSizeMax());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageSizeMax($size)
    {
        $this->cacheRows = null;
        $this->pageSizeMax = $size;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageSizeMax()
    {
        return $this->pageSizeMax;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageNumber($number)
    {
        $this->cacheRows = null;
        $this->pageNumber = min($number, $this->getPageCount());
        $this->pageNumber = max($this->pageNumber, 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageCount()
    {
        return 0 === $this->getPageSize() ? 1 : (int) ceil($this->getSize() / $this->getPageSize());
    }

    /**
     * {@inheritdoc}
     */
    public function setSortColumns(array $columns)
    {
        $this->cacheRows = null;
        $this->config->setSortColumns($columns);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSortColumns()
    {
        return $this->config->getSortColumns();
    }

    /**
     * {@inheritdoc}
     */
    public function getSortColumn($column)
    {
        return $this->config->getSortColumn($column);
    }

    /**
     * {@inheritdoc}
     */
    public function isSorted($column)
    {
        return $this->config->isSorted($column);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameters(array $parameters)
    {
        $this->cacheRows = null;
        $this->size = null;
        $this->config->setParameters($parameters);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->config->getParameters();
    }

    /**
     * Calculates the total size of the source.
     *
     * @return int
     */
    protected function calculateSize()
    {
        return count($this->rows);
    }

    /**
     * Format the index without prefix with dot.
     *
     * @param string $name The index
     *
     * @return string
     */
    protected function formatIndex($name)
    {
        if (is_string($name)) {
            $exp = explode('.', $name);

            if (0 < count($exp)) {
                $name = $exp[count($exp) - 1];
            }
        }

        return $name;
    }

    /**
     * Get the field value of data row.
     *
     * @param array|object  $dataRow
     * @param string        $name
     * @param \Closure|null $emptyData
     *
     * @return mixed|null
     */
    protected function getDataField($dataRow, $name, \Closure $emptyData = null)
    {
        $value = null !== $name && '' !== $name
            ? $this->propertyAccessor->getValue($dataRow, $name)
            : null;

        if (null === $value && $emptyData instanceof \Closure) {
            $value = $emptyData($dataRow, $name);
        }

        return $value;
    }

    /**
     * Paginate the rows.
     *
     * @param array $pagination The pagination
     * @param int   $rowNumber  The row number
     *
     * @return array The paginated rows
     *
     * @throws InvalidConfigurationException When the block renderer is not injected with the "setRenderer" method
     */
    protected function paginateRows(array $pagination, $rowNumber)
    {
        if (null === $this->renderer) {
            throw new InvalidConfigurationException('The block renderer must be injected with "setRenderer" method');
        }

        $cacheRows = array();

        foreach ($this->dataTransformers as $dataTransformer) {
            if ($dataTransformer instanceof PrePaginateTransformerInterface) {
                $pagination = $dataTransformer->prePaginate($this->config, $pagination);
            }
        }

        // loop in rows
        foreach ($pagination as $data) {
            $row = array(
                '_row_number' => $rowNumber++,
                '_attr_columns' => array(),
            );

            if (null !== $this->rowId) {
                $rowId = $this->getDataField($data, $this->rowId);

                if (null !== $rowId) {
                    $row['_row_id'] = $rowId;
                }
            }

            // loop in cells
            /* @var BlockInterface $column */
            foreach ($this->getColumns() as $column) {
                if ($column->hasOption('enabled') && false === $column->getOption('enabled')) {
                    continue;
                }

                if (count($column->getOption('attr')) > 0) {
                    $row['_attr_columns'][$column->getName()] = $column->getOption('attr');
                }

                if ('_row_number' === $column->getOption('index')) {
                    continue;
                }

                $config = $column->getConfig();
                $formatter = $config->getOption('formatter');
                $field = $config->getOption('data_property_path');
                $field = null === $field
                    ? $this->formatIndex($config->getOption('index'))
                    : $field;
                $cellData = $this->getDataField($data, $field, $config->getOption('cell_empty_data'));
                $options = array_replace(array('wrapped' => false, 'inherit_data' => false), $config->getOption('formatter_options'));
                $options = $this->overrideCellOptions($column, $formatter, $data, $options);

                if (TwigType::class === $formatter) {
                    $options = array_merge_recursive($options, array(
                        'variables' => array(
                            '_column' => $column,
                            '_row_data' => $data,
                            '_row_number' => $row['_row_number'],
                        ),
                    ));
                }

                /* @var BlockBuilderInterface $config */
                $cell = $config->getBlockFactory()->createNamed($column->getName(), $formatter, $cellData, $options);
                $row[$column->getName()] = $this->renderer->searchAndRenderBlock($cell->createView(), 'widget');
            }

            if (0 === count($row['_attr_columns'])) {
                unset($row['_attr_columns']);
            }

            $cacheRows[] = $row;
        }

        foreach ($this->dataTransformers as $dataTransformer) {
            if ($dataTransformer instanceof PostPaginateTransformerInterface) {
                $cacheRows = $dataTransformer->postPaginate($this->config, $cacheRows);
            }
        }

        return $cacheRows;
    }

    /**
     * Override the formatter options.
     *
     * @param BlockInterface $column    The block of column
     * @param string         $formatter The formatter class name
     * @param mixed          $data      The data of record
     * @param array          $options   The options of formatter
     *
     * @return array The options overloaded
     */
    protected function overrideCellOptions(BlockInterface $column, $formatter, $data, array $options)
    {
        $config = $column->getConfig();

        if ($config->hasOption('override_options')
                && ($override = $config->getOption('override_options')) instanceof \Closure) {
            /* @var \Closure $override */
            $options = $override($options, $data, $formatter);
        }

        return $options;
    }

    /**
     * Action before getting the data.
     */
    protected function doPreGetData()
    {
        foreach ($this->dataTransformers as $dataTransformer) {
            if ($dataTransformer instanceof PreGetDataTransformerInterface) {
                $dataTransformer->preGetData($this->config);
            }
        }
    }

    /**
     * Action after getting the data.
     */
    protected function doPostGetData()
    {
        foreach ($this->dataTransformers as $dataTransformer) {
            if ($dataTransformer instanceof PostGetDataTransformerInterface) {
                $dataTransformer->postGetData($this->config);
            }
        }
    }
}
