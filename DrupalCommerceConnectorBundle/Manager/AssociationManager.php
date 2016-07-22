<?php

namespace Actualys\Bundle\DrupalCommerceConnectorBundle\Manager;

use Pim\Bundle\CatalogBundle\Repository\AssociationRepositoryInterface;
use Pim\Bundle\CatalogBundle\Entity\AssociationType;

/**
 * Association Manager
 *
 * @author    Benoit Jacquemont <benoit@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AssociationManager
{
    /** @var AssociationRepositoryInterface */
    protected $repository;

    /**
     * @param AssociationRepositoryInterface $repository
     */
    public function __construct(AssociationTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get association count by association type
     *
     * @param AssociationType $type
     *
     * @return int
     */
    public function countForAssociationType(\Pim\Component\Catalog\Model\AssociationTypeInterface $type)
    {
        return $this->repository->countForAssociationType($type);
    }
    /**
     * Get association count by association type
     *
     * @param AssociationType $type
     *
     * @return int
     */
    public function findByProductAndOwnerIds(\Pim\Component\Catalog\Model\ProductInterface $product, array $ownerIds)
    {
        return $this->repository->findByProductAndOwnerIds($product, $ownerIds);
    }
}
