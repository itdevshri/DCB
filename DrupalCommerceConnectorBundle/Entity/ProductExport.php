<?php

namespace Actualys\Bundle\DrupalCommerceConnectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductExport
 */
class ProductExport
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Pim\Component\Catalog\Model\Product
     */
    private $product;

    /**
     * @var \Akeneo\Component\Batch\Model\JobInstance
     */
    private $jobInstance;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ProductExport
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set product
     *
     * @param \Pim\Component\Catalog\Model\Product $product
     *
     * @return ProductExport
     */
    public function setProduct(\Pim\Component\Catalog\Model\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Pim\Component\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set jobInstance
     *
     * @param \Akeneo\Component\Batch\Model\JobInstance $jobInstance
     *
     * @return ProductExport
     */
    public function setJobInstance(\Akeneo\Component\Batch\Model\JobInstance $jobInstance = null)
    {
        $this->jobInstance = $jobInstance;

        return $this;
    }

    /**
     * Get jobInstance
     *
     * @return \Akeneo\Component\Batch\Model\JobInstance
     */
    public function getJobInstance()
    {
        return $this->jobInstance;
    }
}
