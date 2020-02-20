<?php

namespace FondOfSpryker\Zed\Stock\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
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
    private const OPTION_WAREHOUSE = 'warehouse';
    private const OPTION_WAREHOUSE_SHORT = 'w';
    private const OPTION_STORES = 'stores';
    private const OPTION_STORES_SHORT = 's';

    protected $requiredClasses = [
        'Orm/Zed/Stock/Persistence/Base/SpyStockQuery.php'
    ];

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION)
            ->addUsage(sprintf('-%s warehouse -%s store_ids', static::OPTION_WAREHOUSE_SHORT,
                static::OPTION_STORES_SHORT));

        if ($this->validateRequiredStuff()) {
            $this->addOption(
                static::OPTION_WAREHOUSE,
                static::OPTION_WAREHOUSE_SHORT,
                InputOption::VALUE_REQUIRED,
                sprintf(
                    'warehouse name or id. Available warhouse: %s-> %s',
                    PHP_EOL,
                    implode(PHP_EOL.'-> ',
                        $this->formatHelpData($this->getFacade()->getAvailableStockTypes(), ['id' => 'warehouse']))
                )
            );
            $this->addOption(
                static::OPTION_STORES,
                static::OPTION_STORES_SHORT,
                InputOption::VALUE_REQUIRED,
                sprintf(
                    'store names or ids to assign, if emtpy assign to every store: %s-> %s',
                    PHP_EOL,
                    implode(PHP_EOL.'-> ',
                        $this->formatHelpData($this->getFacade()->getSimpleDataStores(), ['id' => 'store']))
                )
            );
        }
    }

    /**
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stores = explode(',', str_replace(' ', '', $input->getOption(static::OPTION_STORES)));
        $warehouse = $input->getOption(static::OPTION_WAREHOUSE);

        $responseTransfer = $this->getFacade()->updateStockByConsole($warehouse, $stores);

        foreach ($responseTransfer->getMessages() as $messageTransfer) {
            $output->writeln(sprintf('%s: %s', $messageTransfer->getType(), $messageTransfer->getValue()));
        }

        return $responseTransfer->getIsSuccessful() ? static::CODE_SUCCESS : static::CODE_ERROR;
    }

    /**
     * @param  array  $data
     * @param  array  $header
     * @return array
     */
    protected function formatHelpData(array $data, array $header = []): array
    {
        if (count($header) > 0) {
            $header = $header + ['--' => '--------------'];
        }
        $output = [];
        foreach (($header + $data) as $key => $value) {
            $output[] = sprintf('%s : %s', $key, $value);
        }
        return $output;
    }

    /**
     * @return bool
     */
    protected function validateRequiredStuff(): bool
    {
        $path = __DIR__.'/../../../../../../../../../src';
        foreach ($this->requiredClasses as $requiredClass) {
            if (!file_exists(sprintf('%s/%s', $path, $requiredClass))){
                return false;
            }
        }

        return true;
    }
}
