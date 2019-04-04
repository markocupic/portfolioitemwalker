<?php
/*
 * This file is part of Contao Portfolio Item Walker.
 *
 * (c) Marko Cupic, april 2019
 * @author Marko Cupic <https://github.com/markocupic/portfolioitemwalker>
 * @license MIT
 */

namespace Markocupic\Portfolioitemwalker;

use Contao\BackendTemplate;
use Contao\Input;
use Contao\FrontendTemplate;
use Contao\NewsModel;
use Contao\Module;
use Contao\PageModel;
use Contao\Config;
use EuF\PortfolioBundle\Models\PortfolioModel;

/**
 * Class ModulePortfolioitemwalker
 * @package Markocupic\Newsitemwalker
 */
class ModulePortfolioitemwalker extends Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_newsitemwalker';

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['portfolioitemwalker'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;
            return $objTemplate->parse();
        }

        // Set the item from the auto_item parameter
        if (Config::get('useAutoItem') && isset($_GET['auto_item']))
        {
            Input::setGet('items', Input::get('auto_item'));
        }

        // Return if no news item has been specified
        if (!Input::get('items'))
        {
            return '';
        }

        return parent::generate();
    }

    /**
     * Generate module
     */
    protected function compile()
    {
        global $objPage;
        $objPageModel = PageModel::findByPk($objPage->id);

        if ($this->portfolioitemwalkerTpl == "")
        {
            $this->portfolioitemwalkerTpl = $this->strTemplate;
        }
        $this->Template = new FrontendTemplate($this->portfolioitemwalkerTpl);

        // Get the pid of the current item
        $objCurrentItem = $this->Database->prepare("SELECT * FROM tl_portfolio WHERE id=? OR alias=?")->limit(1)->execute(Input::get('items'), Input::get('items'));
        $time = time();

        // Previous portfolio item
        $objPrevPortfolio = $this->Database->prepare("SELECT * FROM tl_portfolio WHERE sorting<? AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1 ORDER BY sorting DESC")->limit(1)->execute($objCurrentItem->sorting, $time, $time);
        if ($objPrevPortfolio->numRows > 0)
        {
            $prevHref = $objPageModel->getFrontendUrl((Config::get('useAutoItem') ? '/' : '/items/') . ($objPrevPortfolio->alias ?: $objPrevPortfolio->id));
            $this->Template->prevHref = $prevHref;
            $this->Template->prevLink = '<a href="' . $prevHref . '" title="' . $GLOBALS['TL_LANG']['MSC']['prevPortfolio'][1] . '">' . $GLOBALS['TL_LANG']['MSC']['prevPortfolio'][0] . '</a>';
            $objPortfolio = PortfolioModel::findByPk($objPrevPortfolio->id);
            if ($objPortfolio !== null)
            {
                $this->Template->prevPortfolio = $objPortfolio->row();
                $this->Template->prevId = $objPortfolio->id;
            }
        }

        // Next portfolio item
        $objNextPortfolio = $this->Database->prepare("SELECT * FROM tl_portfolio WHERE sorting>? AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1 ORDER BY sorting ASC")->limit(1)->execute($objCurrentItem->sorting, $time, $time);
        if ($objNextPortfolio->numRows > 0)
        {
            $nextHref = $objPageModel->getFrontendUrl((Config::get('useAutoItem') ? '/' : '/items/') . ($objNextPortfolio->alias ?: $objNextPortfolio->id));
            $this->Template->nextHref = $nextHref;
            $this->Template->nextLink = '<a href="' . $nextHref . '" title="' . $GLOBALS['TL_LANG']['MSC']['nextPortfolio'][1] . '">' . $GLOBALS['TL_LANG']['MSC']['nextPortfolio'][0] . '</a>';
            $objPortfolio = NewsModel::findByPk($objNextPortfolio->id);
            if ($objPortfolio !== null)
            {
                $this->Template->nextPortfolio = $objPortfolio->row();
                $this->Template->nextId = $objPortfolio->id;
            }
        }
    }

}