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


class ModuleAlias extends Module
{

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### MODULE ALIAS ###';
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

