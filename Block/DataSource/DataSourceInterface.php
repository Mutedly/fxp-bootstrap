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

use Sonatra\Component\Block\BlockInterface;
use Sonatra\Component\Block\BlockRendererInterface;
use Sonatra\Component\Block\BlockView;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface DataSourceInterface
{
    /**
     * Set block renderer.
     *
     * @param BlockRendererInterface $renderer
     *
     * @return self
     */
    public function setRenderer(BlockRendererInterface $renderer);

    /**
     * Set table view.
     *
     * @param BlockView $view
     *
     * @return self
     */
    public function setTableView(BlockView $view);

    /**
     * Get table view.
     *
     * @return BlockView
     */
    public function getTableView();

    /**
     * Set columns.
     *
     * @param array $columns The list of column BlockInterface
     *
     * @return self
     */
    public function setColumns(array $columns);

    /**
     * Add column.
     *
     * @param BlockInterface $column
     * @param int            $index
     *
     * @return self
     */
    public function addColumn(BlockInterface $column, $index = null);

    /**
     * Remove column.
     *
     * @param int $index
     *
     * @return self
     */
    public function removeColumn($index);

    /**
     * Get columns.
     *
     * @return array The list of column BlockInterface
     */
    public function getColumns();

    /**
     * Set locale.
     *
     * @param string $locale
     *
     * @return self
     */
    public function setLocale($locale);

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale();

    /**
     * Set rows.
     *
     * @param \Iterator|array $rows
     *
     * @return self
     */
    public function setRows($rows);

    /**
     * Get rows.
     *
     * @return \Iterator
     */
    public function getRows();

    /**
     * Get start.
     *
     * @return int
     */
    public function getStart();

    /**
     * Get end.
     *
     * @return int
     */
    public function getEnd();

    /**
     * Get count of rows.
     *
     * @return int
     */
    public function getSize();

    /**
     * Set page size.
     * If page size equal 0, all row displayed.
     *
     * @param int $size
     *
     * @return self
     */
    public function setPageSize($size);

    /**
     * Get page size.
     * If page size equal 0, all row displayed.
     *
     * @return int
     */
    public function getPageSize();

    /**
     * Set page size max.
     *
     * @param int $size
     *
     * @return self
     */
    public function setPageSizeMax($size);

    /**
     * Get page size max.
     *
     * @return int
     */
    public function getPageSizeMax();

    /**
     * Set page number.
     *
     * @param int $number
     *
     * @return self
     */
    public function setPageNumber($number);

    /**
     * Get page number.
     *
     * @return int
     */
    public function getPageNumber();

    /**
     * Get page count.
     *
     * @return int
     */
    public function getPageCount();

    /**
     * Set sort columns.
     *
     * @param array $columns
     *
     * @return self
     */
    public function setSortColumns(array $columns);

    /**
     * Get sort columns.
     *
     * @return array
     */
    public function getSortColumns();

    /**
     * Get sort column.
     *
     * @param string $column The column name
     *
     * @return string|null
     */
    public function getSortColumn($column);

    /**
     * Check if column is sorted.
     *
     * @param string $column The column name
     *
     * @return bool
     */
    public function isSorted($column);

    /**
     * Set parameters.
     *
     * @param array $parameters
     *
     * @return self
     */
    public function setParameters(array $parameters);

    /**
     * Get parameters.
     *
     * @return array
     */
    public function getParameters();
}
