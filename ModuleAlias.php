<?php

/**
 * z_modulealias Extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2010-2015, terminal42 gmbh
 * @author     terminal42 gmbh <info@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 * @link       http://github.com/terminal42/contao-z_modulealias
 */


namespace Terminal42\ModuleAliasExtension;

class ModuleAlias extends \Module
{

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['modulealias'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		$arrModules = deserialize($this->aliasModules);

		if (is_array($arrModules) && count($arrModules))
		{
			global $objPage;

			$objModules = $this->Database->execute("SELECT id, aliasPages FROM tl_module WHERE id IN (" . implode(',', $arrModules) . ") ORDER BY " . $this->Database->findInSet('id', $arrModules));

			while( $objModules->next() )
			{
				$arrPages = deserialize($objModules->aliasPages);

				if (is_array($arrPages) && count($arrPages))
				{
					foreach( $arrPages as $intPage )
					{
						$arrPages = array_merge($arrPages, $this->getChildRecords($intPage, 'tl_page', false));
					}

					if (in_array($objPage->id, $arrPages))
					{
						return $this->getFrontendModule($objModules->id, $this->inColumn);
					}
				}
			}
		}

		return '';
	}


	/**
	 * Not required but abstract in parent class
	 */
	protected function compile() {}
}

