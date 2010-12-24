<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2010
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id$
 */


/**
 * Palettes
 */
foreach( $GLOBALS['TL_DCA']['tl_module']['palettes'] as $name => $palette )
{
	if ($name == '__selector__')
		continue;
	
	$GLOBALS['TL_DCA']['tl_module']['palettes'][$name] = str_replace('{expert_legend:hide}', '{expert_legend:hide},aliasPages', $palette);
}

$GLOBALS['TL_DCA']['tl_module']['palettes']['modulealias'] = '{title_legend},name,type;{config_legend},aliasModules';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['aliasPages'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['aliasPages'],
	'exclude'			=> true,
	'inputType'			=> 'pageTree',
	'eval'				=> array('fieldType'=>'checkbox'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['aliasModules'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['aliasModules'],
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_module_modulealias', 'getModules'),
	'eval'				=> array('mandatory'=>true, 'multiple'=>true, 'size'=>20),
);



class tl_module_modulealias extends Backend
{
	
	public function getModules($dc)
	{
		$arrModules = array();
		$objModules = $this->Database->execute("SELECT *, (SELECT name FROM tl_theme WHERE tl_module.pid=tl_theme.id) AS theme FROM tl_module WHERE id!={$dc->id} ORDER BY name");
		
		while( $objModules->next() )
		{
			$arrModules[$objModules->theme][$objModules->id] = $objModules->name;
		}
		
		return $arrModules;
	}
}

