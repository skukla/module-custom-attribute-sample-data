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
        \Kukla\TWEAttributeSampleData\Model\Category $categorySetup,
        \Kukla\TWEAttributeSampleData\Model\Attribute $attributeSetup,
        \Kukla\TWEAttributeSampleData\Model\Product $productSetup,
        \Kukla\TWEAttributeSampleData\Model\Swatches $swatchesSetup,
        \Kukla\TWEAttributeSampleData\Model\LumaSuppression $lumaSuppression,
        \Magento\Framework\App\State $state,
        \Magento\CatalogRuleSampleData\Model\Rule $catalogRule,
        \Magento\SalesRuleSampleData\Model\Rule $salesRule,
        \Kukla\TWEAttributeSampleData\Model\Upsells $upsells,
        \Kukla\TWEAttributeSampleData\Model\Review $review,
        \Magento\Indexer\Model\Processor $index,
        \Kukla\TWEAttributeSampleData\Model\ProductPosition $productPosition,
        \Kukla\InstallationOverrides\Model\CategoryProcessorInit $categoryProcessorInit
    ) {
        $this->categorySetup = $categorySetup;
        $this->attributeSetup = $attributeSetup;
        $this->productSetup = $productSetup;
        $this->swatchesSetup = $swatchesSetup;
        $this->lumaSuppression = $lumaSuppression;
        $this->catalogRule  = $catalogRule;
        $this->salesRule = $salesRule;
        $this->upsells = $upsells;
        $this->review = $review;
        $this->index = $index;
        $this->productPosition = $productPosition;
        $this->categoryProcessorInit = $categoryProcessorInit;
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
        //set up text and color swatches
        $this->swatchesSetup->install();
        //add categories
        $this->categorySetup->install(['Kukla_TWEAttributeSampleData::fixtures/categories.csv','Kukla_TWEAttributeSampleData::fixtures/lookBookCategories.csv']);
        //suppress most luma products from venia store
        $this->productSetup->install(['Kukla_TWEAttributeSampleData::fixtures/suppressLumaProductsFromVenia.csv']);
        //suppress luma bundle and downloadable products from venia. These cannot be done via import
        $this->lumaSuppression->install(['Kukla_TWEAttributeSampleData::fixtures/suppressAdditionalLumaProductsFromVenia.csv']);
        //add venia products
        $this->categoryProcessorInit->runInit();
        $this->productSetup->install(['Kukla_TWEAttributeSampleData::fixtures/veniaProducts.csv']);
        //set position of Shop the Look products
        $this->productPosition->install(['Kukla_TWEAttributeSampleData::fixtures/productPosition.csv']);
        //add catalog promos
        $this->catalogRule->install(['Kukla_TWEAttributeSampleData::fixtures/catalogRules.csv']);
        //add cart promos
        $this->salesRule->install(['Kukla_TWEAttributeSampleData::fixtures/salesRules.csv']);
        //add upsells
        $this->upsells->install(['Kukla_TWEAttributeSampleData::fixtures/upsells.csv']);
        //add reviews
        $this->review->install(['Kukla_TWEAttributeSampleData::fixtures/reviews.csv']);
        //add video
        //reIndex as MECE redeploy will not automatically reindex
        $this->index->reindexAll();

    }
}
