<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Block\DataSource;

use Fxp\Component\Block\BlockInterface;
use Fxp\Component\Block\Exception\InvalidArgumentException;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class DataSourceConfig
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @var array
     */
    protected $columns = array();

    /**
     * @var array|null
     */
    protected $mappingColumns = null;

    /**
     * @var array
     */
    protected $sortColumns = array();

    /**
     * @var array
     */
    protected $mappingSortColumns = array();

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @var int
     */
    protected $pageNumber = 1;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->locale = \Locale::getDefault();
    }

    /**
     * Set locale.
     *
     * @param string $locale
     *
     * @return self
     */
    public function setLocale($locale = null)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set columns.
     *
     * @param BlockInterface[] $columns The list of column
     *
     * @return self
     */
    public function setColumns(array $columns)
    {
        $this->mappingColumns = null;
        $this->columns = array_values($columns);

        return $this;
    }

    /**
     * Add column.
     *
     * @param BlockInterface $column
     * @param int            $index
     *
     * @return self
     */
    public function addColumn(BlockInterface $column, $index = null)
    {
        $this->mappingColumns = null;

        if (null !== $index) {
            array_splice($this->columns, $index, 0, $column);
        } else {
            array_push($this->columns, $column);
        }

        return $this;
    }

    /**
     * Remove column.
     *
     * @param int $index
     *
     * @return self
     */
    public function removeColumn($index)
    {
        $this->mappingColumns = null;
        array_splice($this->columns, $index, 1);

        return $this;
    }

    /**
     * Get columns.
     *
     * @return BlockInterface[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set sort columns.
     *
     * @param array $columns
     *
     * @return self
     */
    public function setSortColumns(array $columns)
    {
        $this->sortColumns = array();
        $this->mappingSortColumns = array();

        foreach ($columns as $i => $column) {
            if (!isset($column['name'])) {
                throw new InvalidArgumentException('The "name" property of sort column must be present ("sort" property is optional)');
            }

            if (isset($column['sort']) && 'asc' !== $column['sort'] && 'desc' !== $column['sort']) {
                throw new InvalidArgumentException('The "sort" property of sort column must have "asc" or "desc" value');
            }

            if ($this->isSorted($column['name'])) {
                throw new InvalidArgumentException(sprintf('The "%s" column is already sorted', $column['name']));
            }

            $this->sortColumns[] = $column;
            $this->mappingSortColumns[$column['name']] = $i;
        }

        return $this;
    }

    /**
     * Get sort columns.
     *
     * @return array
     */
    public function getSortColumns()
    {
        return $this->sortColumns;
    }

    /**
     * Get sort column.
     *
     * @param string $column The column name
     *
     * @return string|null
     */
    public function getSortColumn($column)
    {
        $val = null;

        if ($this->isSorted($column)) {
            $def = $this->sortColumns[$this->mappingSortColumns[$column]];

            if (isset($def['sort'])) {
                $val = $def['sort'];
            }
        }

        return $val;
    }

    /**
     * Check if column is sorted.
     *
     * @param string $column The column name
     *
     * @return bool
     */
    public function isSorted($column)
    {
        return array_key_exists($column, $this->mappingSortColumns);
    }

    /**
     * Set parameters.
     *
     * @param array $parameters
     *
     * @return self
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Return the index name of column.
     *
     * @param string $name
     *
     * @return string The index
     *
     * @throws InvalidArgumentException When column does not exit
     */
    public function getColumnIndex($name)
    {
        if (!is_array($this->mappingColumns)) {
            $this->mappingColumns = array();

            /* @var BlockInterface $column */
            foreach ($this->getColumns() as $i => $column) {
                $this->mappingColumns[$column->getName()] = $i;
            }
        }

        if (isset($this->mappingColumns[$name])) {
            $column = $this->columns[$this->mappingColumns[$name]];

            return $column->getOption('index');
        }

        throw new InvalidArgumentException(sprintf('The column name "%s" does not exist', $name));
    }
}
