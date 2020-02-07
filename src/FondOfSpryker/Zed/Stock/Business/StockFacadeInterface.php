<?php

namespace FondOfSpryker\Zed\Stock\Business;

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
}
