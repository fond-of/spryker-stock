<?php

namespace FondOfSpryker\Zed\Stock\Business;

use Generated\Shared\Transfer\StockResponseTransfer;
use \Spryker\Zed\Stock\Business\StockFacadeInterface as SprykerStockFacadeInterface;

/**
 * @method \FondOfSpryker\Zed\Stock\Business\StockBusinessFactory getFactory()
 */
interface StockFacadeInterface extends SprykerStockFacadeInterface
{
    /**
     * @return array
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getSimpleDataStores(): array;

    /**
     * @param  string  $warehouse
     * @param  array  $stores
     * @return \Generated\Shared\Transfer\StockResponseTransfer
     * @throws \FondOfSpryker\Zed\Stock\Exception\StockNotFoundException
     */
    public function updateStockByConsole(string $warehouse, array $stores): StockResponseTransfer;
}
