<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Bootstrap\Block\Extension;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Fxp\Component\Block\AbstractTypeExtension;
use Fxp\Component\Block\BlockBuilderInterface;
use Fxp\Component\Bootstrap\Block\Type\TableType;
use Fxp\Component\Bootstrap\Doctrine\ORM\Block\DataSource\DoctrineOrmDataSource;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Table Doctrine ORM Block Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TableDoctrineOrmExtension extends AbstractTypeExtension
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildBlock(BlockBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();

        if ($data instanceof QueryBuilder) {
            $data = $data->getQuery();
        }

        if ($data instanceof Query) {
            $source = new DoctrineOrmDataSource($this->entityManager, $options['row_id']);
            $source->setPageSizeMax($options['page_size_max']);
            $source->setPageSize($options['page_size']);
            $source->setQuery($data);
            $source->setLocale($options['locale']);
            $source->setSortColumns($options['sort_columns']);
            $source->setParameters($options['data_parameters']);
            $source->setPageNumber($options['page_number']);

            $builder->setData($source);
            $builder->setDataClass(get_class($source));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->addAllowedTypes('data', ['Doctrine\ORM\Query', 'Doctrine\ORM\QueryBuilder']);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return TableType::class;
    }
}
