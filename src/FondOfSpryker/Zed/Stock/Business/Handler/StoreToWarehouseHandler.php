<?php

namespace FondOfSpryker\Zed\Stock\Business\Handler;

use FondOfSpryker\Zed\Stock\Exception\StockNotFoundException;
use Generated\Shared\Transfer\StockResponseTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Spryker\Zed\Stock\Business\Stock\StockReaderInterface;
use Spryker\Zed\Stock\Business\Stock\StockUpdaterInterface;
use Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeInterface;
use Spryker\Zed\Stock\Persistence\StockRepositoryInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class StoreToWarehouseHandler implements StoreToWarehouseHandlerInterface
{
    /**
     * @var \Spryker\Zed\Stock\Business\Stock\StockUpdaterInterface
     */
    protected $stockUpdater;

    /**
     * @var \Spryker\Zed\Stock\Persistence\StockRepositoryInterface
     */
    protected $stockRepository;

    /**
     * @var \Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeInterface 
     */
    protected $storeFacade;

    /**
     * StoreToWarehouseHandler constructor.
     * @param  \Spryker\Zed\Stock\Business\Stock\StockUpdaterInterface  $stockUpdater
     * @param  \Spryker\Zed\Stock\Persistence\StockRepositoryInterface  $stockRepository
     * @param  \Spryker\Zed\Stock\Dependency\Facade\StockToStoreFacadeInterface  $storeFacade
     */
    public function __construct(
        StockUpdaterInterface $stockUpdater,
        StockRepositoryInterface $stockRepository,
        StockToStoreFacadeInterface $storeFacade
    ) {
        $this->stockUpdater = $stockUpdater;
        $this->stockRepository = $stockRepository;
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param  string  $warehouse
     * @param  array  $stores
     * @return \Generated\Shared\Transfer\StockResponseTransfer
     * @throws \FondOfSpryker\Zed\Stock\Exception\StockNotFoundException
     */
    public function addStoresToWarehouse(string $warehouse, array $stores): StockResponseTransfer
    {
        $stockTransfer = $this->resolveStock($warehouse);
        if (!$stockTransfer) {
            throw new StockNotFoundException(sprintf('Stock with name or id %s not found!', $warehouse));
        }

        $storeRelation = $stockTransfer->getStoreRelation();
        $storeRelation->setIdStores($this->prepareStores($stores));

        $stockTransfer->setStoreRelation($storeRelation);

        return $this->stockUpdater->updateStock($stockTransfer);
    }

    /**
     * @param  string  $warehouse
     * @return \Generated\Shared\Transfer\StockTransfer|null
     */
    protected function resolveStock(string $warehouse): ?StockTransfer
    {
        if (is_numeric($warehouse)) {
            return $this->stockRepository->findStockById((int) $warehouse);
        }

        return $this->stockRepository->findStockByName($warehouse);
    }

    /**
     * @param  array  $stores
     * @return array
     */
    protected function prepareStores(array $stores): array
    {
        $storeIds = [];
        $availableStores = $this->storeFacade->getAllStores();
        foreach ($availableStores as $availableStore) {
            if (in_array($availableStore->getIdStore(), $stores) || in_array($availableStore->getName(),
                    $stores) || in_array((string) $availableStore->getIdStore(), $stores)) {
                $storeIds[] = $availableStore->getIdStore();
            }
        }
        return $storeIds;
    }
}
