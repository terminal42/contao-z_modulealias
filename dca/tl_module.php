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
 * Palettes
 */
foreach( $GLOBALS['TL_DCA']['tl_module']['palettes'] as $name => $palette )
{
	if ($name == '__selector__')
		continue;

	$GLOBALS['TL_DCA']['tl_module']['palettes'][$name] = str_replace('{expert_legend:hide}', '{expert_legend:hide},aliasPages', $palette, $count);

	if (!$count)
	{
		$GLOBALS['TL_DCA']['tl_module']['palettes'][$name] .= ';{expert_legend:hide},aliasPages;';
	}
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
	'eval'				=> array('fieldType'=>'checkbox', 'multiple'=>true),
	'sql'               => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['aliasModules'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['aliasModules'],
	'exclude'			=> true,
	'inputType'			=> 'checkboxWizard',
	'options_callback'	=> array('tl_module_modulealias', 'getModules'),
	'eval'				=> array('mandatory'=>true, 'multiple'=>true),
	'sql'               => "blob NULL"
);



class tl_module_modulealias extends Backend
{

	public function getModules($dc)
	{
		$arrModules = array();
		$objModules = $this->Database->execute("SELECT * FROM tl_module WHERE id!={$dc->id} AND pid=(SELECT id FROM tl_theme WHERE tl_module.pid=tl_theme.id) ORDER BY name");

		while( $objModules->next() )
		{
			$arrModules[$objModules->id] = $objModules->name;
		}

		return $arrModules;
	}
}

