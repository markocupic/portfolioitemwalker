<?php
/*
 * This file is part of Contao Portfolio Item Walker.
 *
 * (c) Marko Cupic, april 2019
 * @author Marko Cupic <https://github.com/markocupic/portfolioitemwalker>
 * @license MIT
 */


array_insert($GLOBALS['FE_MOD'], 2, array
(
    'portfolio' => array
    (
        'portfolioitemwalker' => 'Markocupic\Portfolioitemwalker\ModulePortfolioitemwalker'
    )
));
