<?php

/**
 * PAYONE Magento 2 Connector is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PAYONE Magento 2 Connector is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with PAYONE Magento 2 Connector. If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @category  Payone
 * @package   Payone_Magento2_Plugin
 * @author    FATCHIP GmbH <support@fatchip.de>
 * @copyright 2003 - 2017 Payone GmbH
 * @license   <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link      http://www.payone.de
 */

namespace Payone\Core\Test\Unit\Setup;

use Payone\Core\Setup\InstallSchema as ClassToTest;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Payone\Core\Model\Test\BaseTestCase;
use Payone\Core\Model\Test\PayoneObjectManager;

class InstallSchemaTest extends BaseTestCase
{
    /**
     * @var ClassToTest
     */
    private $classToTest;

    /**
     * @var ObjectManager|PayoneObjectManager
     */
    private $objectManager;

    protected function setUp()
    {
        $this->objectManager = $this->getObjectManager();

        $this->classToTest = $this->objectManager->getObject(ClassToTest::class);
    }

    public function testInstall()
    {
        $table = $this->getMockBuilder(Table::class)->disableOriginalConstructor()->getMock();

        $connection = $this->getMockBuilder(AdapterInterface::class)->disableOriginalConstructor()->getMock();
        $connection->method('isTableExists')->willReturn(false);
        $connection->method('newTable')->willReturn($table);

        $installer = $this->getMockBuilder(SchemaSetupInterface::class)->disableOriginalConstructor()->getMock();
        $installer->method('getConnection')->willReturn($connection);
        $installer->method('getTable')->willReturn('table');
        $installer->method('getIdxName')->willReturn('name');

        $context = $this->getMockBuilder(ModuleContextInterface::class)->disableOriginalConstructor()->getMock();
        $context->method('getVersion')->willReturn('1.1.0');

        $result = $this->classToTest->install($installer, $context);
        $this->assertNull($result);
    }
}
