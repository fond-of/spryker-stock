<?php

namespace FondOfSpryker\Zed\Stock\Communication;

use FondOfSpryker\Zed\Stock\StockDependencyProvider;
use \Spryker\Zed\Stock\Communication\StockCommunicationFactory as SprykerStockCommunicationFactory;
use Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeBridge;

/**
 * @method \FondOfSpryker\Zed\Stock\StockConfig getConfig()
 */
class StockCommunicationFactory extends SprykerStockCommunicationFactory
{
    /**
     * @return \Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeBridge
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getStoreFacade(): StockToStoreFacadeBridge
    {
        return $this->getProvidedDependency(StockDependencyProvider::FACADE_STORE);
    }
}
