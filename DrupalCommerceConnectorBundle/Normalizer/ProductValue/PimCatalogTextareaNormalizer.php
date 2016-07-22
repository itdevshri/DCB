<?php

namespace Actualys\Bundle\DrupalCommerceConnectorBundle\Normalizer\ProductValue;

use Pim\Bundle\CatalogBundle\Model\ProductValue;

/**
 * Class PimCatalogTextarea
 *
 * @package Actualys\Bundle\DrupalCommerceConnectorBundle\Normalizer
 */
class PimCatalogTextareaNormalizer implements ProductValueNormalizerInterface
{
    /**
     * @param array        $drupalProduct
     * @param ProductValue $productValue
     * @param string       $field
     * @param array        $context
     */
    public function normalize(
      array &$drupalProduct,
      $productValue,
      $field,
      array $context = array()
    ) {
        $text = $productValue->getText();

        $attribute = $productValue->getAttribute();
        if (null !== $text) {
            $drupalProduct['values'][$field][$context['locale']][] = array(
              'type' => 'pim_catalog_textarea',
              'value' => $text,
            );
        }
    }
}
