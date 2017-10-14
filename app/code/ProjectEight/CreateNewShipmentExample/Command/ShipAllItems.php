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
 * @package     ProjectEight\CreateNewShipmentExample
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\CreateNewShipmentExample\Command;

use Magento\Framework\App\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShipAllItems extends Command
{
    /**
     * ShipAllItems constructor.
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
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName("projecteight:examples:create-new-shipment:ship-all-items");
        $this->setDescription("Programmatically create a new shipment to ship all order items");
        parent::configure();
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws \Magento\Sales\Api\Exception\CouldNotShipExceptionInterface When a shipment can not be created
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objectManager = ObjectManager::getInstance();
        $orderId       = 4;
        $output->writeln("Output start");

        // In production code, you would inject these dependencies via the constructor,
        // rather than use the Object Manager

        /** @var \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoaderFactory $shipmentLoaderFactory */
        $shipmentLoaderFactory = $objectManager->get(
            \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoaderFactory::class
        );
        /** @var \Magento\Sales\Api\OrderRepositoryInterface $orderRepository */
        $orderRepository = $objectManager->get(\Magento\Sales\Api\OrderRepositoryInterface::class);

        try {
            $output->writeln("Shipping all order items in order ID {$orderId}...");

            // Get the order
            /** @var \Magento\Sales\Api\Data\OrderInterface $order */
            $order = $orderRepository->get($orderId);

            // Create an empty shipment object and assign the order ID to it
            /** @var \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader */
            $shipmentLoader = $shipmentLoaderFactory->create();
            $shipmentLoader->setOrderId($order->getId());

            // Load the shipment if it exists, or create a new one if not
            /** @var \Magento\Sales\Model\Order\Shipment $shipment */
            $shipment = $shipmentLoader->load();
            if ($shipment) {
                // Prepare all shippable items for shipment
                $shipment->register();
                // Make sure order is in right state
                $shipment->getOrder()->setIsInProcess(true);
                // Create a transaction factory object
                $transactionFactory = $objectManager->get(\Magento\Framework\DB\TransactionFactory::class);
                // Add shipment and order to transaction
                $orderShipmentTransaction = $transactionFactory->create()
                                                              ->addObject($shipment)
                                                              ->addObject($shipment->getOrder());
                // Commit transaction
                $orderShipmentTransaction->save();

                $output->writeln("Shipment {$shipment->getIncrementId()} created");

                $qtyShipped = 0;
                foreach ($order->getItems() as $orderItem) {
                    $qtyShipped += $orderItem->getQtyShipped();
                }
                $totalQtyOrdered = (int)$order->getTotalQtyOrdered();
                $output->writeln("Shipped {$qtyShipped} out of {$totalQtyOrdered} ordered items");
            } else {
                $output->writeln("All shippable items in this order have been shipped");
            }
        } catch (\Magento\Sales\Api\Exception\CouldNotShipExceptionInterface $exception) {
            $output->writeln("Could not create shipment: " . $exception->getMessage());
        }
        $output->writeln("Output finish");

        return null;
    }
}
