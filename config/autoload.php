<?php

/**
 * z_modulealias Extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2010-2015, terminal42 gmbh
 * @author     terminal42 gmbh <info@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 * @link       http://github.com/terminal42/contao-z_modulealias
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Terminal42\ModuleAliasExtension\ModuleAlias' => 'system/modules/z_modulealias/ModuleAlias.php',
));
