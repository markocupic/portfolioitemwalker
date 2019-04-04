<?php

// Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['portfolioitemwalker'] = 'name,type;{config_legend};{template_legend},portfolioitemwalkerTpl;{expert_legend:hide},cssID,space';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['portfolioitemwalkerTpl'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['portfolioitemwalkerTpl'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_portfolioitemwalker', 'getPortfolioitemwalkerTemplates'),
       'sql'                     => "varchar(64) NOT NULL default ''"
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

}
