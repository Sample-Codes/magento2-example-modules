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
 * @package     ProjectEight\AddTrackingInfoToShipmentExample
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddTrackingInfoToShipmentExample\Command;

use Magento\Framework\App\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TrackAllItems extends Command
{
    /**
     * TrackAllItems constructor.
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
        $this->setName("projecteight:examples:add-tracking-info:track-all-items");
        $this->setDescription("Programmatically add tracking info to an existing shipment");
        parent::configure();
    }

    /**
     * Executes the current command.
     *
     * @see \Magento\Shipping\Controller\Adminhtml\Order\Shipment\AddTrack
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
        $shipmentId    = 5;
        $response = [];
        $output->writeln("Output start");

        try {
            $output->writeln("Adding tracking info to shipment {$shipmentId} in order {$orderId}");

            $carrier = "custom";
            $number  = "9876543210";
            $title   = "Royal Mail";
            if (empty($carrier)) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Please specify a carrier.'));
            }
            if (empty($number)) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Please enter a tracking number.'));
            }

            // In production code, you would inject these dependencies via the constructor,
            // rather than use the Object Manager

            /** @var \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoaderFactory $shipmentLoaderFactory */
            $shipmentLoaderFactory = $objectManager->get(
                \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoaderFactory::class
            );

            // Create an empty shipment object and assign the order ID to it
            /** @var \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader */
            $shipmentLoader = $shipmentLoaderFactory->create();
            $shipmentLoader->setOrderId($orderId);
            $shipmentLoader->setShipmentId($shipmentId);
            $shipmentLoader->setShipment(null);
            $shipmentLoader->setTracking(null);

            // Load the shipment if it exists, or create a new one if not
            /** @var \Magento\Sales\Model\Order\Shipment $shipment */
            $shipment = $shipmentLoader->load();
            if ($shipment) {
                // Believe it or not, this is how it is done in the core
                /**
                 * @TODO Refactor to remove dependency on object manager
                 */
                $track = $objectManager->create('Magento\Sales\Model\Order\Shipment\Track');
                $track->setNumber($number);
                $track->setCarrierCode($carrier);
                $track->setTitle($title);
                $shipment->addTrack($track);
                /**
                 * This is how it is done in the core
                 * @TODO Refactor this to use a repository (if possible).
                 */
                $shipment->save();
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $response = ['error' => true, 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            $response = ['error' => true, 'message' => __('Cannot add tracking number.')];
        }

        $output->writeln(print_r($response));

        $output->writeln("Output finish");

        return null;
    }
}
