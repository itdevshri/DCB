<?php

namespace Actualys\Bundle\DrupalCommerceConnectorBundle\Processor;

use Akeneo\Component\Batch\Model\StepExecution;
use Akeneo\Component\Batch\Item\InvalidItemException;
use Akeneo\Component\Batch\Item\ItemProcessorInterface;
use Pim\Bundle\CatalogBundle\Manager\ProductManager;
use Pim\Bundle\CatalogBundle\Manager\ChannelManager;
use Pim\Bundle\CatalogBundle\Entity\Channel;
use Pim\Component\Catalog\Model\ProductInterface;
use Actualys\Bundle\DrupalCommerceConnectorBundle\Normalizer\Exception\NormalizeException;
use Actualys\Bundle\DrupalCommerceConnectorBundle\Normalizer\ProductNormalizer;
use Actualys\Bundle\DrupalCommerceConnectorBundle\Item\DrupalItemStep;

class ProductProcessor extends DrupalItemStep implements ItemProcessorInterface
{
    /** @var StepExecution */
    protected $stepExecution;

    /** @var ProductManager */
    protected $productManager;

    /** @var  ChannelManager */
    protected $channelManager;

    /** @var  array */
    protected $globalContext;

    /** @var  ProductNormalizer */
    protected $productNormalizer;

    /** @var  Channel $channel */
    protected $channel;


    /**
     * @param ProductManager    $productManager
     * @param ChannelManager    $channelManager
     * @param ProductNormalizer $productNormalizer
     */
    public function __construct(
      ProductManager $productManager,
      ChannelManager $channelManager,
      ProductNormalizer $productNormalizer
    ) {
        $this->productManager    = $productManager;
        $this->channelManager    = $channelManager;
        $this->productNormalizer = $productNormalizer;
    }

    /**
     * @param  mixed                $product
     * @return array|mixed
     * @throws InvalidItemException
     */
    public function process($product)
    {
        /** @var Channel $channel */
        $channel = $this->channelManager->getChannelByCode($this->channel);

        return $this->normalizeProduct($product, $channel);
    }

    /**
     * Normalize the given product
     *
     * @param ProductInterface $product [description]
     * @param Channel          $channel
     *
     * @throws InvalidItemException If a normalization error occurs
     *
     * @return array processed item
     */
    protected function normalizeProduct(
      ProductInterface $product,
      Channel $channel
    ) {
        try {
            $processedItem = $this->productNormalizer->normalize(
              $product,
              null,
              [
                'channel'       => $channel,
                'configuration' => $this->getConfiguration()
              ]
            );
        } catch (NormalizeException $e) {
            throw new InvalidItemException(
              $e->getMessage(),
              [
                'id'                                                 => $product->getId(
                ),
                $product->getIdentifier()->getAttribute()->getCode(
                )                                                    => $product->getIdentifier(
                )->getData(),
                'label'                                              => $product->getLabel(
                ),
                'family'                                             => $product->getFamily(
                )->getCode()
              ]
            );
        }

        return $processedItem;
    }

    /**
     * Get fields for the twig
     *
     * @return array
     */
    public function getConfigurationFields()
    {
        return array_merge(
          parent::getConfigurationFields(),
          [
            'channel'     => [
              'type'    => 'choice',
              'options' => [
                'choices'  => $this->channelManager->getChannelChoices(),
                'required' => true,
                'help'     => 'actualys_drupal_commerce_connector.export.channel.help',
                'label'    => 'actualys_drupal_commerce_connector.export.channel.label',
              ],
            ],
          ]
        );
    }

    /**
     * @return Channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }
}
