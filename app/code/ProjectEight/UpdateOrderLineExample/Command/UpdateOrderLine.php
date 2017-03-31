<?php
namespace ProjectEight\UpdateOrderLineExample\Command;

use Magento\Framework\App\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateOrderLine extends Command
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
        $appState->setAreaCode('frontend');
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("projecteight:examples:update-order-line");
        $this->setDescription("Demonstrates updating sales order lines in Magento 2");
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
        $orderInvoice = $objectManager->get(\Magento\Sales\Model\InvoiceOrder::class);

        try {
            $output->writeln("Invoicing all order items");
            $orderInvoiceId = $orderInvoice->execute($orderId, true);
            $output->writeln("Created invoice ID: " . $orderInvoiceId);
        } catch (\Magento\Sales\Api\Exception\CouldNotInvoiceExceptionInterface $exception) {
            $output->writeln("Could not create invoice:" . $exception->getMessage());
        } catch (\Magento\Sales\Exception\DocumentValidationException $exception) {
            $output->writeln("Invoice validation exception:" . $exception->getMessage());
        }

        $output->writeln("Output finish");
    }
}
