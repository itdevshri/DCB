<?php

namespace Actualys\Bundle\DrupalCommerceConnectorBundle\Writer;

use Akeneo\Bundle\BatchBundle\Entity\JobInstance;
use Pim\Bundle\CatalogBundle\Manager\ChannelManager;
use Actualys\Bundle\DrupalCommerceConnectorBundle\Manager\ProductExportManager;
use Akeneo\Component\Batch\Model\StepExecution;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Guzzle\Http\Exception\ClientErrorResponseException;

class DeltaProductWriter extends ProductWriter
{
    /**
     * @var ProductExportManager
     */
    protected $productExportManager;

    /**
     * @var JobInstance
     */
    protected $jobInstance;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param EventDispatcher      $eventDispatcher
     * @param ChannelManager       $channelManager
     * @param ProductExportManager $productExportManager
     */
    public function __construct(
      EventDispatcherInterface $eventDispatcher,
      ChannelManager $channelManager,
      ProductExportManager $productExportManager
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->productExportManager = $productExportManager;
    }

    /**
     * @param array $items
     */
    public function write(array $items)
    {
        parent::write($items);
        foreach ($items as $item) {
            $this->productExportManager->updateProductExport(
              $item['sku'],
              $this->jobInstance
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setStepExecution(StepExecution $stepExecution)
    {
        parent::setStepExecution($stepExecution);

        $this->jobInstance = $stepExecution->getJobExecution()->getJobInstance(
        );
    }
}
