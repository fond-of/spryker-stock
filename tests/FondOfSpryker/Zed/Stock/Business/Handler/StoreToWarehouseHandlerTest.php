<?php

namespace FondOfSpryker\Zed\Stock\Business\Handler;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Stock\Exception\StockNotFoundException;
use Generated\Shared\Transfer\StockResponseTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Spryker\Zed\Stock\Business\Stock\StockUpdaterInterface;
use Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeInterface;
use Spryker\Zed\Stock\Persistence\StockRepository;
use Spryker\Zed\Stock\Persistence\StockRepositoryInterface;

/**
 * Auto-generated group annotations
 * @group FondOfSpryker
 * @group Zed
 * @group Stock
 * @group Business
 * @group Handler
 * @group StoreToWarehouseHandlerTest
 * Add your own group annotations below this line
 */
class StoreToWarehouseHandlerTest extends Unit
{
    protected $handler;

    public function setUp()
    {
        $this->handler = new StoreToWarehouseHandler(
            $this->createStockUpdaterMock(),
            $this->createStockRepositoryMock(),
            $this->createStockToStoreFacadeBridgeMock()
        );
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     */
    public function testAddStoresToWarehouse(): void
    {
        $this->handler->addStoresToWarehouse('EU', [0 => 1, 1 => 2]);
    }

    /**
     * @return void
     * @expectedException \FondOfSpryker\Zed\Stock\Exception\StockNotFoundException
     */
    public function testAddStoresToWarehouseWillThrowException(): void
    {
        $handler = new StoreToWarehouseHandler(
            $this->createStockUpdaterMock(),
            $this->getMockBuilder(StockRepository::class)->disableOriginalConstructor()->setMethods([
                'findStockById', 'findStockByName'
            ])->getMock(),
            $this->createStockToStoreFacadeBridgeMock()
        );
        $handler->addStoresToWarehouse('EU', [0 => 1, 1 => 2]);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function createStockUpdaterMock()
    {
        $mock = $this->getMockBuilder(StockUpdaterInterface::class)->disableOriginalConstructor()->setMethods(['updateStock'])->getMock();
        $mock->method('updateStock')->willReturn($this->createStockResponseTransferMock());
        return $mock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function createStockRepositoryMock()
    {
        $mock = $this->getMockBuilder(StockRepository::class)->disableOriginalConstructor()->setMethods([
            'findStockById', 'findStockByName'
        ])->getMock();
        $mock->method('findStockById')->willReturn($this->createStockTransferMock());
        $mock->method('findStockByName')->willReturn($this->createStockTransferMock());
        return $mock;
    }

    /**
     * @param  bool  $emtpy
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function createStockToStoreFacadeBridgeMock(bool $emtpy = false)
    {
        $mock = $this->getMockBuilder(StockToStoreFacadeInterface::class)->disableOriginalConstructor()->setMethods([
            'getAllStores', 'getCurrentStore'
        ])->getMock();
        $stores = [];
        if (!$emtpy) {
            $stores[] = $this->createStoreTransferMock(1, 'a');
            $stores[] = $this->createStoreTransferMock(2, 'b');
        }
        $mock->method('getAllStores')->willReturn($stores);

        return $mock;
    }

    /**
     * @param  int  $storeId
     * @param  string  $name
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function createStoreTransferMock(int $storeId, string $name)
    {
        $storeTransferMock = $this->getMockBuilder(StoreTransfer::class)->setMethods([
            'getIdStore', 'getName'
        ])->getMock();
        $storeTransferMock->method('getIdStore')->willReturn($storeId);
        $storeTransferMock->method('getName')->willReturn($name);
        return $storeTransferMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function createStockResponseTransferMock()
    {
        $mock = $this->getMockBuilder(StockResponseTransfer::class)->setMethods(['getIsSuccessful'])->getMock();

        return $mock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function createStockTransferMock()
    {
        $testcase = $this;
        $mock = $this->getMockBuilder(StockTransfer::class)->setMethods([
            'getStoreRelation', 'setStoreRelation'
        ])->getMock();
        $mock->method('getStoreRelation')->willReturn($this->createStoreRelationTransferMock());
        $mock->method('setStoreRelation')->willReturnCallback(function ($x) use ($testcase) {
            $testcase->assertTrue($x instanceof StoreRelationTransfer);
        });
        return $mock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function createStoreRelationTransferMock()
    {
        $testcase = $this;
        $mock = $this->getMockBuilder(StoreRelationTransfer::class)->setMethods(['setIdStores'])->getMock();
        $mock->method('setIdStores')->willReturnCallback(function ($x) use ($testcase) {
            $testcase->assertEquals([0 => 1, 1 => 2], $x);
        });
        return $mock;
    }
}