<?php
 
namespace Mteam\Link\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_request;
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
     \Magento\Framework\App\Request\Http $request
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_request=$request;

        return parent::__construct($context);
    }
 
    public function execute()
    {   /*
        * getting product id from $_GET request 
        */
        // getting object manager
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $productId =  $this->_request->getParam('productid');
        if(!$productId){
            // redirect to main page if no product id 
                $this->_redirect('/');
        }else{
                // getting object manager
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            // getting cart quote
            $cart = $objectManager->get('\Magento\Checkout\Model\Session')->getQuote();
            // getting all items in cart
            $result = $cart->getAllVisibleItems();
            // checkinf if item already in cart 
            $itemInCart = false;
            foreach ($result as $cartItem) {
                if($cartItem->getProduct()->getId() == $productId){
                    $itemInCart = true;
                    break;
                }
            }
            /*
            * if item in cart then redirect to checkout page
            */
            if($itemInCart){
                return $this->resultRedirectFactory->create()
            ->setPath('checkout/cart');

            }else{
                $this->messageManager->addSuccess(
                    __('Redirecting to cart page')
                );
                return  $this->_resultPageFactory->create();
            }
        }
    }
}
