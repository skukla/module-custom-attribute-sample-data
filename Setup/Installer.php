<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kukla\TWEAttributeSampleData\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
{
    /**
     * Setup class for category
     *
     * @var \Kukla\TWEAttributeSampleData\Model\Category
     */
    protected $categorySetup;

    /**
     * Setup class for product attributes
     *
     * @var \Kukla\TWEAttributeSampleData\Model\Attribute
     */
    protected $attributeSetup;

    /**
     * Setup class for products
     *
     * @var \Kukla\TWEAttributeSampleData\Model\Product
     */
    protected $productSetup;

    /**
     * Convert fashion_color and fashion_size attribute to swatches
     *
     * @var \Kukla\TWEAttributeSampleData\Model\Swatches
     */
    protected $swatchesSetup;

    /**
     * Suppress downloadable and bundled Luma products from Venia
     *
     * @var \Kukla\TWEAttributeSampleData\Model\LumaSuppression
     */
    protected $lumaSuppression;


    /**
     * Upsells
     *
     * @var \Kukla\TWEAttributeSampleData\Model\Upsells
     */
    protected $upsells;


    /**
     * App State
     *
     * @var \Magento\Framework\App\State
     */
    protected $state;
    /**
     * @var \Magento\CatalogRuleSampleData\Model\Rule
     */
    protected $catalogRule;
    /**
     * @var \Magento\SalesRuleSampleData\Model\Rule
     */
    protected $salesRule;

    /**
     * @var \Kukla\TWEAttributeSampleData\Model\Review
     */
    protected $review;

    /**
     * @var \Kukla\TWEAttributeSampleData\Model\ProductPosition
     */
    protected $productPosition;

    /**
     * @var \Kukla\InstallationOverrides\Model\CategoryProcessorInit
     */
    protected $categoryProcessorInit;

    /**
     * @param \Kukla\TWEAttributeSampleData\Model\Category $categorySetup
     * @param \Kukla\TWEAttributeSampleData\Model\Attribute $attributeSetup
     * @param \Kukla\TWEAttributeSampleData\Model\Product $productSetup
     * @param \Kukla\TWEAttributeSampleData\Model\Swatches $swatchesSetup
     * @param \Kukla\TWEAttributeSampleData\Model\LumaSuppression $lumaSuppression
     * @param \Magento\Framework\App\State $state
     * @param \Magento\CatalogRuleSampleData\Model\Rule $catalogRule
     * @param \Magento\SalesRuleSampleData\Model\Rule $salesRule
     * @param \Kukla\TWEAttributeSampleData\Model\Upsells $upsells
     * @param \Kukla\TWEAttributeSampleData\Model\Review $review
     * @param \Magento\Indexer\Model\Processor $index
     * @param \Kukla\TWEAttributeSampleData\Model\ProductPosition $productPosition
     * @param  \Kukla\InstallationOverrides\Model\CategoryProcessorInit $categoryProcessorInit
     */


    public function __construct(
        \Kukla\TWEAttributeSampleData\Model\Attribute $attributeSetup,
        \Magento\Framework\App\State $state,
        \Magento\Indexer\Model\Processor $index
    ) {
        $this->attributeSetup = $attributeSetup;
        $this->index = $index;
        try{
            $state->setAreaCode('adminhtml');
        }
        catch(\Magento\Framework\Exception\LocalizedException $e){
            // left empty
        }

    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        //add attributes
        $this->attributeSetup->install(['Kukla_TWEAttributeSampleData::fixtures/attributes.csv']);
        //reindex
        $this->index->reindexAll();

    }
}
