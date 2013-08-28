<?php

namespace Usu\ScryptPasswordEncoderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('usu_scrypt_password_encoder');

        $rootNode
            ->children()
                ->scalarNode('cpu_cost')->defaultValue(2048)->end()
            ->end()
            ->children()
                ->scalarNode('memory_cost')->defaultValue(2)->end()
            ->end()
            ->children()
                ->scalarNode('parallelization_cost')->defaultValue(1)->end()
            ->end()
            ->children()
                ->scalarNode('key_length')->defaultValue(64)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
