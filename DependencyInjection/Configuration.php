<?php

namespace Artprima\Bundle\FormsExtraBundle\DependencyInjection;

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
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('artprima_forms_extra');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('artprima_forms_extra');
        }
        
        $rootNode
            ->children()
                ->scalarNode('twig_form_widget')
                    ->defaultValue('ArtprimaFormsExtraBundle:Form:field_widget.html.twig')
                    ->info('Custom form fields widgets')
                    ->example('FormsExtraBundle:Form:field_widget.html.twig')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
