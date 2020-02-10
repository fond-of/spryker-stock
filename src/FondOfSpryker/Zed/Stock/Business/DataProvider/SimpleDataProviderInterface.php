<?php


namespace FondOfSpryker\Zed\Stock\Business\DataProvider;


use FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface;
use FondOfSpryker\Zed\Stock\Exception\DataTypeNotExistsException;

interface SimpleDataProviderInterface
{
    /**
     * @param  \FondOfSpryker\Zed\Stock\Communication\Dependency\DataProviderInterface  $dataProvider
     */
    public function registerDataProvider(DataProviderInterface $dataProvider): void;

    /**
     * @param  string  $dataType
     * @return array
     * @throws \FondOfSpryker\Zed\Stock\Exception\DataTypeNotExistsException
     */
    public function get(string $dataType): array;

    /**
     * @return array
     */
    public function getRegisteredDataProviderTypes(): array;

    /**
     * @return string
     */
    public function getRegisteredDataProviderTypesAsString(): string;
}
