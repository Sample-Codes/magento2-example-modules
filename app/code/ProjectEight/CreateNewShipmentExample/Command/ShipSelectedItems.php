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

class ShipSelectedItems extends Command
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
        $this->setName("projecteight:examples:create-new-shipment:ship-selected-items");
        $this->setDescription("Programmatically create a new shipment to ship selected order items");
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
        $orderId       = 1;
        $qtyToShip     = 1;
        $output->writeln("Output start");

        // In production code, you would inject these dependencies via the constructor,
        // rather than use the Object Manager

        /** @var \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoaderFactory $shipmentLoaderFactory */
        $shipmentLoaderFactory = $objectManager->get(\Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoaderFactory::class);
        /** @var \Magento\Sales\Api\OrderRepositoryInterface $orderRepository */
        $orderRepository = $objectManager->get(\Magento\Sales\Api\OrderRepositoryInterface::class);

        try {
            $output->writeln("Shipping all order items");

            /** @var \Magento\Sales\Api\Data\OrderInterface $order */
            $order = $orderRepository->get($orderId);

            /** @var \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader */
            $shipmentLoader = $shipmentLoaderFactory->create();

            // For demonstration purposes, we'll only process the first order item
            $orderItems     = $order->getItems();
            $firstOrderItem = reset($orderItems);

            $shipmentData = [$firstOrderItem->getId() => $qtyToShip];
            $shipmentLoader->setOrderId($order->getId());
            $shipmentLoader->setShipment($shipmentData);

            /** @var \Magento\Sales\Model\Order\Shipment $shipment */
            $shipment = $shipmentLoader->load();
            if ($shipment) {
                $shipment->register();
                $shipment->getOrder()->setIsInProcess(true);
                $transactionFactory       = $objectManager->get(\Magento\Framework\DB\TransactionFactory::class);
                $orderShipmentTransaction = $transactionFactory->create()
                                                               ->addObject($shipment)
                                                               ->addObject($shipment->getOrder());
                $orderShipmentTransaction->save();
            }
            $qtyShipped = 0;
            foreach ($order->getItems() as $orderItem) {
                $qtyShipped += $orderItem->getQtyShipped();
            }
            $totalQtyOrdered = (int)$order->getTotalQtyOrdered();
            $output->writeln("Shipped {$qtyShipped} out of {$totalQtyOrdered} items ordered");
        } catch (\Magento\Sales\Api\Exception\CouldNotShipExceptionInterface $exception) {
            $output->writeln("Could not create shipment: " . $exception->getMessage());
        }
        $output->writeln("Output finish");

        return null;
    }
}
