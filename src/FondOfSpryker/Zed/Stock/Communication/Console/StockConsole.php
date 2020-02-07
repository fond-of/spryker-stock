<?php

namespace FondOfSpryker\Zed\Stock\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfSpryker\Zed\Stock\Business\StockFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\Stock\Persistence\StockRepositoryInterface getRepository()
 * @method \FondOfSpryker\Zed\Stock\Communication\StockCommunicationFactory getFactory()
 */
class StockConsole extends Console
{
    private const COMMAND_NAME = 'stock:warehouse:assign';
    private const DESCRIPTION = 'Assigns warehouse to store';
    private const ARGUMENT_WAREHOUSE = 'warehouse';
    private const ARGUMENT_STORES = 'stores';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);
        $this->addArgument(static::ARGUMENT_WAREHOUSE, InputArgument::REQUIRED, 'warehouse name or id');
        $this->addArgument(static::ARGUMENT_STORES, InputArgument::REQUIRED, 'store names or ids to assign');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stores = $input->getArgument(static::ARGUMENT_STORES);
        $warehouse = $input->getArgument(static::ARGUMENT_WAREHOUSE);

        $output->writeln('');

        return static::CODE_SUCCESS;
    }
}
