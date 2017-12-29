<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Block\Type;

use Fxp\Component\Block\AbstractType;

/**
 * Table Row Block Type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TableRowType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'table_row';
    }
}
