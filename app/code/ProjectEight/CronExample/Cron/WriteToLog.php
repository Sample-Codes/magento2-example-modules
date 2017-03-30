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
 * @category    magento2-sample-modules.localhost.com
 * @package     ProjectEight\CronExample\Cron
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\CronExample\Cron;

use Psr\Log\LoggerInterface;

/**
 * CronExample cron actions
 */
class WriteToLog
{
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * WriteToLog constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Write to log. By default writes to var/log/debug.log
     *
     * @return \ProjectEight\CronExample\Cron\WriteToLog
     */
    public function execute()
    {
        $this->logger->debug("This message came from " . __METHOD__);

        return $this;
    }
}
