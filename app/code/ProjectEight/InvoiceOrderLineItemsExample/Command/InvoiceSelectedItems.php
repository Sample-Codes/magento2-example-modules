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

class InvoiceSelectedItems extends Command
{
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
        $this->setName("projecteight:examples:invoice-order-line-items:invoice-selected-items");
        $this->setDescription("Demonstrates updating sales order lines by invoicing selected items in Magento 2");
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objectManager = ObjectManager::getInstance();
        $orderId       = 2;

        $output->writeln("Output start");

        /** @var \Magento\Sales\Model\Service\InvoiceService $invoiceService */
        $invoiceService = $objectManager->get(\Magento\Sales\Api\InvoiceManagementInterface::class);
        /** @var \Magento\Sales\Api\OrderRepositoryInterface $orderRepository */
        $orderRepository = $objectManager->get(\Magento\Sales\Api\OrderRepositoryInterface::class);

        try {
            $output->writeln("Invoicing selected order items");

            /** @var \Magento\Sales\Api\Data\OrderInterface $order */
            $order = $orderRepository->get($orderId);

            $orderItems     = $order->getItems();
            $firstOrderItem = reset($orderItems);

            /** @var \Magento\Sales\Model\Order\Invoice $orderInvoice */
            $orderInvoice = $invoiceService->prepareInvoice($order, [$firstOrderItem->getItemId() => 2]);
            $orderInvoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_OFFLINE);
            if ($orderInvoice) {
                $orderInvoice->register();
                $orderInvoice->getOrder()->setIsInProcess(true);
                $transactionFactory = $objectManager->get(\Magento\Framework\DB\TransactionFactory::class);
                $orderInvoiceTransaction = $transactionFactory->create()
                                                               ->addObject($orderInvoice)
                                                               ->addObject($orderInvoice->getOrder());
                $orderInvoiceTransaction->save();
            }

            $qtyInvoiced = 0;
            foreach ($order->getItems() as $orderItem) {
                $qtyInvoiced += $orderItem->getQtyInvoiced();
            }
            $totalQtyOrdered = (int)$order->getTotalQtyOrdered();

            $output->writeln("Invoiced {$qtyInvoiced} out of {$totalQtyOrdered} items ordered");
        } catch (\Magento\Sales\Api\Exception\CouldNotInvoiceExceptionInterface $exception) {
            $output->writeln("Could not create invoice: " . $exception->getMessage());
        } catch (\Magento\Sales\Exception\DocumentValidationException $exception) {
            $output->writeln("Invoice validation exception: " . $exception->getMessage());
        }

        $output->writeln("Output finish");
    }
}
