<?php

declare(strict_types=1);

namespace Darake\SculpinInsertBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sculpin_insert');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('insert_content')->end()
            ->end();

        return $treeBuilder;
    }
}
