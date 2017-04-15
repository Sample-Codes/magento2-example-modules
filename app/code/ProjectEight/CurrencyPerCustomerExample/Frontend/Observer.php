<?php
namespace ProjectEight\CurrencyPerCustomerExample\Frontend;

class Observer implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Store model
     *
     * @var \Magento\Store\Model\Store
     */
    private $store;

    /**
     * Observer constructor.
     *
     * @param \Magento\Store\Model\Store $store
     */
    public function __construct(\Magento\Store\Model\Store $store)
    {
        $this->store = $store;
    }

    /**
     * Dispatched by customer_data_object_login
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return $this|void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $attributes = $observer->getEvent()->getCustomer()->getCustomAttributes();

        $assignedCurrency = $attributes['p8_assigned_currency'];

        if ($this->store->getCurrentCurrencyCode() !== $assignedCurrency->getValue()) {
            $this->store->setCurrentCurrencyCode($assignedCurrency->getValue());
        }

        return $this;
    }
}
