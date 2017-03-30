<?php
/**
 * Created by PhpStorm.
 * User: zone8
 * Date: 29/03/17
 * Time: 17:50
 */

namespace ProjectEight\Ftp\Test\Unit;

use Magento\TestFramework\ObjectManager;
use ProjectEight\Ftp\Model\Ftp;

class FtpTest extends \PHPUnit_Framework_TestCase
{

//    public function testEverythingWorks()
//    {
//        $this->assertSame( true, true);
//    }

    /** @var ObjectManager */
    protected $objectManager;

    public function setUp()
    {
        $this->objectManager = ObjectManager::getInstance();
    }

    public function testCanOpenFtpConnection()
    {
        /** @var Ftp $ftpMock */
        $ftpMock = $this->objectManager->get('ProjectEight\Ftp\Model\Ftp');
    }
}
