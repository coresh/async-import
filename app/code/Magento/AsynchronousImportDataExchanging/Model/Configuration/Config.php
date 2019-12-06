<?php

namespace Magento\AsynchronousImportDataExchanging\Model\Configuration;

use Magento\Framework\App\DeploymentConfig;
use Magento\AsynchronousImportDataExchanging\Exception\InvalidReceiverConfigurationException;

class Config implements ConfigInterface
{
    /** @var DeploymentConfig */
    private $deploymentConfig;

    /**
     * Config constructor.
     *
     * @param DeploymentConfig $deploymentConfig
     */
    public function __construct(
        DeploymentConfig $deploymentConfig
    ) {
        $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * Loads the configured exchange adapter
     *
     * @return string
     */
    public function getAdapter()
    {
        /** @var string $key */
        $key = self::ASYNCHRONOUS_IMPORT_NODE . "/" . self::EXCHANGE_ADAPTER_NODE;

        return $this->deploymentConfig->get(
            $key,
            self::DEFAULT_EXCHANGE_ADAPTER
        );
    }

    /**
     * Returns the receiver details
     * @param string $adapterName
     * @return array
     */
    public function getReceiverDetails($adapterName)
    {
        /** @var string $key */
        $key = self::ASYNCHRONOUS_IMPORT_NODE . "/" . $adapterName . "/" . self::PARAMETERS_NODE;

        /** @var array $data */
        $data = $this->deploymentConfig->get($key);

        if (!isset($data[self::INTEGRATION_TOKEN]) || !isset($data[self::BASE_URL])) {
            throw new InvalidReceiverConfigurationException(__('Invalid receiver configuration. Please check env.php'));
        }

        return $data;
    }
}
