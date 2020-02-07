<?php

namespace FondOfSpryker\Zed\Stock;

use FondOfSpryker\Zed\Stock\Business\DataProvider\Plugin\StoreDataProviderPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeBridge;
use \Spryker\Zed\Stock\StockDependencyProvider as SprykerStockDependencyProvider;

class StockDependencyProvider extends SprykerStockDependencyProvider
{
    public const PLUGINS_SIMPLE_DATA_PROVIDER = 'PLUGINS_SIMPLE_DATA_PROVIDER';

    /**
     * @param  \Spryker\Zed\Kernel\Container  $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->registerSimpleDataProviderPlugins($container);

        return $container;
    }

    /**
     * @param  \Spryker\Zed\Kernel\Container  $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addStoreFacade($container);
        $container = $this->registerSimpleDataProviderPlugins($container);

        return $container;
    }

    /**
     * @param  \Spryker\Zed\Kernel\Container  $container
     * @return \Spryker\Zed\Kernel\Container
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException
     */
    public function registerSimpleDataProviderPlugins(Container $container): Container
    {
        $storeFacade = $container->get(static::FACADE_STORE);
        $container[static::PLUGINS_SIMPLE_DATA_PROVIDER] = function (Container $container) use ($storeFacade) {
            return [
                new StoreDataProviderPlugin($storeFacade),
            ];
        };
        return $container;
    }
}
