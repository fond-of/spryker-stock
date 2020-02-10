<?php

namespace FondOfSpryker\Zed\Stock\Business;

use FondOfSpryker\Zed\Stock\Business\DataProvider\SimpleDataProvider;
use FondOfSpryker\Zed\Stock\Business\DataProvider\SimpleDataProviderInterface;
use FondOfSpryker\Zed\Stock\Business\Handler\StoreToWarehouseHandler;
use FondOfSpryker\Zed\Stock\StockDependencyProvider;
use \Spryker\Zed\Stock\Business\StockBusinessFactory as SprykerStockBusinessFactory;
use Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeBridge;

/**
 * @method \FondOfSpryker\Zed\Stock\StockConfig getConfig()
 * @method \Spryker\Zed\Stock\Persistence\StockQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Stock\Persistence\StockRepositoryInterface getRepository()
 * @method \Spryker\Zed\Stock\Persistence\StockEntityManagerInterface getEntityManager()
 */
class StockBusinessFactory extends SprykerStockBusinessFactory
{
    /**
     * @return \Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeBridge
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getStoreFacade(): StockToStoreFacadeBridge
    {
        return $this->getProvidedDependency(StockDependencyProvider::FACADE_STORE);
    }

    /**
     * @return array|\FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface[]
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getSimpleDataProviderPlugins(): array
    {
        return $this->getProvidedDependency(StockDependencyProvider::PLUGINS_SIMPLE_DATA_PROVIDER);
    }

    /**
     * @return \FondOfSpryker\Zed\Stock\Business\DataProvider\SimpleDataProviderInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createSimpleDataProvider(): SimpleDataProviderInterface
    {
        return new SimpleDataProvider($this->getSimpleDataProviderPlugins());
    }
    
    public function createStoreToWarehouseHandler(){
        return new StoreToWarehouseHandler(
            $this->createStockUpdater(),
            $this->getRepository(),
            $this->getStoreFacade()
        );
    }
}
