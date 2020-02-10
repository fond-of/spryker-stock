<?php

namespace FondOfSpryker\Zed\Stock\Business\DataProvider\Plugin;

use FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface;
use Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeInterface;

class StoreDataProviderPlugin implements DataProviderInterface
{
    public const DATA_TYPE = 'storeData';
     
    /**
     * @var \Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeInterface
     */
    protected $storeFacade;

    public function __construct(StockToStoreFacadeInterface $storeFacade)
    {
        $this->storeFacade = $storeFacade;
    }

    /**
     * @return array
     */
    public function getDataAsArray(): array
    {
        return $this->prepareStoreData();
    }

    public function getName(): string
    {
        return static::DATA_TYPE;
    }

    /**
     * @return array
     */
    protected function prepareStoreData(): array
    {
        $storeData = [];
        foreach ($this->storeFacade->getAllStores() as $storeTransfer) {
            $storeData[$storeTransfer->getIdStore()] = $storeTransfer->getName();
        }

        return $storeData;
    }


}
