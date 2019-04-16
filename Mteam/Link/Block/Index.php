<?php
namespace Mteam\Link\Block;
class Index extends \Magento\Framework\View\Element\Template
{	protected $_request;
	public function __construct(\Magento\Framework\View\Element\Template\Context $context)
	{	

		parent::__construct($context);
	}

	public function getProductInfo() {
		$productId = $this->getRequest()->getParam('productid');

		$quantity = (null  !== $this->_request->getParam('qty')) ?  $this->_request->getParam('qty') : 1;

		// getting object manager
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		// getting product info
		$product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
		$listBlock = $objectManager->get('\Magento\Catalog\Block\Product\ListProduct');
		// getting cart url
		$addToCartUrl =  $listBlock->getAddToCartUrl($product);
		$productInfo  = array(
			'url'=>$addToCartUrl,
			'product'=>$product,
			'productId'=>$productId,
			'quantity'=>$quantity
		);
		return $productInfo;

	}

}