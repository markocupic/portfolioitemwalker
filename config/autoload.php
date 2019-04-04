<?php
/*
 * This file is part of Contao Portfolio Item Walker.
 *
 * (c) Marko Cupic, april 2019
 * @author Marko Cupic <https://github.com/markocupic/portfolioitemwalker>
 * @license MIT
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'Markocupic',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Modules
    'Markocupic\Portfolioitemwalker\ModulePortfolioitemwalker' => 'system/modules/portfolioitemwalker/modules/ModulePortfolioitemwalker.php',

));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'mod_portfolioitemwalker' => 'system/modules/portfolioitemwalker/templates',
));
