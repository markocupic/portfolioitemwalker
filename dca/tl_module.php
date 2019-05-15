<?php

// Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['portfolioitemwalker'] = 'name,type;{config_legend},useConfigFromPortfolioitemwalkerListingModule;{template_legend},portfolioitemwalkerTpl;{expert_legend:hide},cssID,space';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['portfolioitemwalkerTpl'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_module']['portfolioitemwalkerTpl'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_module_portfolioitemwalker', 'getPortfolioitemwalkerTemplates'),
    'eval'             => array('tl_class' => 'w50'),
    'sql'              => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['useConfigFromPortfolioitemwalkerListingModule'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_module']['useConfigFromPortfolioitemwalkerListingModule'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_module_portfolioitemwalker', 'getPortfolioListingModules'),
    'eval'             => array('mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50'),
    'sql'              => "int(10) unsigned NOT NULL default '0'",
);

/**
 * Class tl_module_portfolioitemwalker
 */
class tl_module_portfolioitemwalker extends Backend
{

    /**
     * @return array
     */
    public function getPortfolioitemwalkerTemplates()
    {
        return $this->getTemplateGroup('mod_portfolioitemwalker');
    }

    /**
     * @return array
     */
    public function getPortfolioListingModules()
    {
        $arrModules = array();
        $objModules = $this->Database->prepare('SELECT * FROM tl_module WHERE type=? ORDER BY name ASC')->execute('portfoliolist');
        while ($objModules->next())
        {
            $arrModules[$objModules->id] = $objModules->name;
        }
        return $arrModules;
    }

}
