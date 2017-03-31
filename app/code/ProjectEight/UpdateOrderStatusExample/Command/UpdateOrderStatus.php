<?php
namespace ProjectEight\UpdateOrderStatusExample\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateOrderStatus extends Command
{
    protected function configure()
    {
        $this->setName("projecteight:examples:update-order-status");
        $this->setDescription("Demonstrates updating order status programmatically");
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello World");
    }
}
