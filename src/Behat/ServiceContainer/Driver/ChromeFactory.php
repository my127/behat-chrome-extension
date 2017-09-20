<?php
namespace DMore\ChromeExtension\Behat\ServiceContainer\Driver;

use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use DMore\ChromeDriver\ChromeDriver;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;

final class ChromeFactory implements DriverFactory
{
    /**
     * {@inheritdoc}
     */
    public function getDriverName()
    {
        return 'chrome';
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder->children()
            ->scalarNode('api_url')->end()
            ->booleanNode('validate_certificate')->defaultTrue()->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function buildDriver(array $config)
    {
        $validateCert = isset($config['validate_certificate']) ? $config['validate_certificate'] : true;
        return new Definition(ChromeDriver::class, [
            $config['api_url'],
            null,
            '%mink.base_url%',
            [
                'validateCertificate' => $validateCert
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsJavascript()
    {
        return true;
    }
}
