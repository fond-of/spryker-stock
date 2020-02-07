<?php
namespace FondOfSpryker\Zed\Stock\Communication\Dependency;

interface DataProviderInterface
{
    /**
     * @return array
     */
    public function getDataAsArray(): array;

    /**
     * @return string
     */
    public function getName(): string;
}
