<?php

namespace FondOfSpryker\Zed\Stock\Business;

use Generated\Shared\Transfer\StoreTransfer;
use \Spryker\Zed\Stock\Business\StockFacade as SprykerStockFacade;

/**
 * @method \FondOfSpryker\Zed\Stock\Business\StockBusinessFactory getFactory()
 */
class StockFacade extends SprykerStockFacade implements StockFacadeInterface
{
    /**
     * @return array
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getSimpleDataStores(): array
    {
        return $this->getFactory()->createSimpleDataProvider()->get('storeData');
    }
}
