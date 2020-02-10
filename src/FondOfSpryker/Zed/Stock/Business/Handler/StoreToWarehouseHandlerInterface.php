<?php

namespace FondOfSpryker\Zed\Stock\Business\Handler;

use Generated\Shared\Transfer\StockResponseTransfer;

interface StoreToWarehouseHandlerInterface
{
    /**
     * @param  string  $warehouse
     * @param  array  $stores
     * @return \Generated\Shared\Transfer\StockResponseTransfer
     * @throws \FondOfSpryker\Zed\Stock\Exception\StockNotFoundException
     */
    public function addStoresToWarehouse(string $warehouse, array $stores): StockResponseTransfer;
}
