# Stock API Module
[![Build Status](https://travis-ci.org/fond-of/spryker-stock.svg?branch=master)](https://travis-ci.org/fond-of/spryker-stock)
[![PHP from Travis config](https://img.shields.io/travis/php-v/symfony/symfony.svg)](https://php.net/)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/fond-of-spryker/stock)

## Description

Adds console command "stock:warehouse:assign". Since the ZED backend can not handle the store to warehouse assignment by gui (gateway timeout). Just use the console to handle it.
```
vendor/bin/console stock:warehouse:assign -w STORENAME_OR_ID -s STORE_NAMES_OR_IDS

stock:warehouse:assign -w EU -s 1,4,5,6
stock:warehouse:assign -w EU -s STORE,STORE2,STORE3
stock:warehouse:assign -w 1 -s 1,STORE2,3
```

## Installation

```
composer require fond-of-spryker/stock
```

Register "src/FondOfSpryker/Zed/Stock/Communication/Console/StockConsole.php" in "src/Pyz/Zed/Console/ConsoleDependencyProvider.php"

```
/**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Symfony\Component\Console\Command\Command[]
     */
    protected function getConsoleCommands(Container $container)
    {
        $commands = [
            ...
            new StockConsole(),
        ];
```
