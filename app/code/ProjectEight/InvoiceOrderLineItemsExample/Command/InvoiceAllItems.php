<?php
/**
 * ProjectEight
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact ProjectEight for more information.
 *
 * @category    ProjectEight\magento2-example-modules
 * @package     ProjectEight\InvoiceOrderLineItemsExample
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */
namespace ProjectEight\InvoiceOrderLineItemsExample\Command;

use Magento\Framework\App\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InvoiceAllItems extends Command
{
    /**
     * Magento Framework App State
     *
     * @var \Magento\Framework\App\State $appState
     */
    protected $appState;

    /**
     * UpdateOrderLine constructor.
     *
     * @param \Magento\Framework\App\State $appState
     * @param null                         $name
     */
    public function __construct(
        \Magento\Framework\App\State $appState,
        $name = null
    ) {

        $this->appState = $appState;

        try {
            $appState->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            $appState->setAreaCode('frontend');
        }
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("projecteight:examples:invoice-order-line-items:invoice-all-items");
        $this->setDescription("Demonstrates updating sales order lines by invoicing selected items in Magento 2");
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objectManager = ObjectManager::getInstance();
        $orderId       = 1;

        $output->writeln("Output start");

        /** @var \Magento\Sales\Model\InvoiceOrder $orderInvoice */
        $orderInvoice = $objectManager->get(\Magento\Sales\Api\InvoiceOrderInterface::class);

        try {
            $output->writeln("Invoicing all order items");
            $orderInvoiceId = $orderInvoice->execute($orderId, true);
            $output->writeln("Created invoice ID: " . $orderInvoiceId);
        } catch (\Magento\Sales\Api\Exception\CouldNotInvoiceExceptionInterface $exception) {
            $output->writeln("Could not create invoice: " . $exception->getMessage());
        } catch (\Magento\Sales\Exception\DocumentValidationException $exception) {
            $output->writeln("Invoice validation exception: " . $exception->getMessage());
        }

        $output->writeln("Output finish");
    }
}
