<?php

namespace ZIMZIM\ConstructionSiteBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ZIMZIMConstructionSiteExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter($this->getAlias() . '.constructionsite_class', $config['constructionsite_class']);
        $container->setParameter($this->getAlias() . '.constructionsite_repo', $config['constructionsite_repo']);
        $container->setParameter($this->getAlias() . '.constructionsite_form', $config['constructionsite_form']);

        $container->setParameter($this->getAlias() . '.typeactionitem_class', $config['typeactionitem_class']);
        $container->setParameter($this->getAlias() . '.typeactionitem_repo', $config['typeactionitem_repo']);
        $container->setParameter($this->getAlias() . '.typeactionitem_form', $config['typeactionitem_form']);

        $container->setParameter($this->getAlias() . '.actionitem_class', $config['actionitem_class']);
        $container->setParameter($this->getAlias() . '.actionitem_repo', $config['actionitem_repo']);
        $container->setParameter($this->getAlias() . '.actionitem_form', $config['actionitem_form']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
