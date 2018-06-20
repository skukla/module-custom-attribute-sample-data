<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kukla\CustomAttributeSampleData\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
{
    /**
     * Setup class for category
     *
     * @var \Kukla\CustomAttributeSampleData\Model\Category
     */
    protected $categorySetup;

    /**
     * Setup class for product attributes
     *
     * @var \Kukla\CustomAttributeSampleData\Model\Attribute
     */
    protected $attributeSetup;

    /**
     * Setup class for products
     *
     * @var \Kukla\CustomAttributeSampleData\Model\Product
     */
    protected $productSetup;

    /**
     * Convert fashion_color and fashion_size attribute to swatches
     *
     * @var \Kukla\CustomAttributeSampleData\Model\Swatches
     */
    protected $swatchesSetup;

    /**
     * Suppress downloadable and bundled Luma products from Venia
     *
     * @var \Kukla\CustomAttributeSampleData\Model\LumaSuppression
     */
    protected $lumaSuppression;


    /**
     * Upsells
     *
     * @var \Kukla\CustomAttributeSampleData\Model\Upsells
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
     * @var \Kukla\CustomAttributeSampleData\Model\Review
     */
    protected $review;

    /**
     * @var \Kukla\CustomAttributeSampleData\Model\ProductPosition
     */
    protected $productPosition;

    /**
     * @var \Kukla\InstallationOverrides\Model\CategoryProcessorInit
     */
    protected $categoryProcessorInit;

    /**
     * @param \Kukla\CustomAttributeSampleData\Model\Category $categorySetup
     * @param \Kukla\CustomAttributeSampleData\Model\Attribute $attributeSetup
     * @param \Kukla\CustomAttributeSampleData\Model\Product $productSetup
     * @param \Kukla\CustomAttributeSampleData\Model\Swatches $swatchesSetup
     * @param \Kukla\CustomAttributeSampleData\Model\LumaSuppression $lumaSuppression
     * @param \Magento\Framework\App\State $state
     * @param \Magento\CatalogRuleSampleData\Model\Rule $catalogRule
     * @param \Magento\SalesRuleSampleData\Model\Rule $salesRule
     * @param \Kukla\CustomAttributeSampleData\Model\Upsells $upsells
     * @param \Kukla\CustomAttributeSampleData\Model\Review $review
     * @param \Magento\Indexer\Model\Processor $index
     * @param \Kukla\CustomAttributeSampleData\Model\ProductPosition $productPosition
     * @param  \Kukla\InstallationOverrides\Model\CategoryProcessorInit $categoryProcessorInit
     */


    public function __construct(
        \Kukla\CustomAttributeSampleData\Model\Attribute $attributeSetup,
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
        $this->attributeSetup->install(['Kukla_CustomAttributeSampleData::fixtures/attributes.csv']);
        //reindex
        $this->index->reindexAll();

    }
}
