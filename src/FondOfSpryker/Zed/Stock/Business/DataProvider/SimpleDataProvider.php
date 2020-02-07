<?php

namespace FondOfSpryker\Zed\Stock\Business\DataProvider;

use FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface;
use FondOfSpryker\Zed\Stock\Exception\DataTypeNotExistsException;

class SimpleDataProvider implements SimpleDataProviderInterface
{
    /**
     * @var \FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface[]
     */
    protected $dataProviderCollection;

    /**
     * SimpleDataProvider constructor.
     * @param  array|\FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface[]  $dataProviderCollection
     */
    public function __construct(array $dataProviderCollection = [])
    {
        $this->init($dataProviderCollection);
    }

    /**
     * @param  \FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface  $dataProvider
     */
    public function regsiterDataProvider(DataProviderInterface $dataProvider): void
    {
        $this->dataProviderCollection[$dataProvider->getName()] = $dataProvider;
    }

    /**
     * @param  string  $dataType
     * @return array
     * @throws \FondOfSpryker\Zed\Stock\Exception\DataTypeNotExistsException
     */
    public function get(string $dataType): array
    {
        if (!array_key_exists($dataType, $this->dataProviderCollection)) {
            throw new DataTypeNotExistsException(sprintf('No data provider found for type %s', $dataType));
        }
        return $this->dataProviderCollection[$dataType]->getDataAsArray();
    }

    /**
     * @return array
     */
    public function getRegisteredDataProviderTypes(): array
    {
        return array_keys($this->dataProviderCollection);
    }

    /**
     * @return string
     */
    public function getRegisteredDataProviderTypesAsString(): string
    {
        return implode('-> '.PHP_EOL, $this->getRegisteredDataProviderTypes());
    }

    /**
     * @param  array|\FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface[]  $dataProviderCollection
     *
     * @return void
     */
    protected function init(array $dataProviderCollection): void
    {
        foreach ($dataProviderCollection as $dataProvider) {
            $this->regsiterDataProvider($dataProvider);
        }
    }

}
