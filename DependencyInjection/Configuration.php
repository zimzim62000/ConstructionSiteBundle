<?php

namespace ZIMZIM\ConstructionSiteBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zimzim_construction_site');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
            ->scalarNode('constructionsite_class')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('constructionsite_repo')->defaultValue('ZIMZIM\ConstructionSiteBundle\Model\ConstructionSiteRepository')->end()
            ->scalarNode('constructionsite_form')->defaultValue('zimzim_constructionsitebundle_constructionsitetype')->end()
            ->scalarNode('typeactionitem_class')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('typeactionitem_repo')->defaultValue('ZIMZIM\ConstructionSiteBundle\Model\TypeActionItemRepository')->end()
            ->scalarNode('typeactionitem_form')->defaultValue('zimzim_constructionsitebundle_typeactionitemtype')->end()
            ->scalarNode('actionitem_class')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('actionitem_repo')->defaultValue('ZIMZIM\ConstructionSiteBundle\Model\ActionItemRepository')->end()
            ->scalarNode('actionitem_form')->defaultValue('zimzim_constructionsitebundle_actionitemtype')->end();

        return $treeBuilder;
    }
}
