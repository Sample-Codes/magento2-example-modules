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
 * @package     ProjectEight\UpdateOrderStatusExample
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\UpdateOrderStatusExample\Command;

use Magento\Sales\Model\Order;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateOrderStatus extends Command
{
    /**
     * UpdateOrderStatus constructor.
     *
     * @param \Magento\Framework\App\State $appState
     * @param null                         $name
     */
    public function __construct(
        \Magento\Framework\App\State $appState,
        $name = null
    ) {
        $appState->setAreaCode('frontend');
        parent::__construct($name);
    }

    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName("projecteight:examples:update-order-status");
        $this->setDescription("Demonstrates updating order status programmatically");
        parent::configure();
    }

    /**
     * Execute command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        /** @var \Magento\Sales\Model\OrderRepository $orderRepository */
        $orderRepository = $objectManager->get(\Magento\Sales\Api\OrderRepositoryInterface::class);

        /** @var Order $order */
        $order = $orderRepository->get(1);
        $output->writeln("Output start");
        $orderStatus = $order->getStatus();
        $output->writeln("Order status: " . $orderStatus);

        $newOrderStatus = ($orderStatus == 'pending') ? 'processing' : 'pending';

        $order->addStatusToHistory($newOrderStatus, "Status updated to {$newOrderStatus} by CLI command");

        $output->writeln("Setting order status to " . $newOrderStatus);
        $order->setStatus($newOrderStatus);
        $order->save();

        $output->writeln("Order status: " . $order->getStatus());
        $output->writeln("Output finish");
    }
}
