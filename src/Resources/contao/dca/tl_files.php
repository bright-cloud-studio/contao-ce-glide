<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-glide
 */

use Contao\Controller;

// Get our default 'tl_content' DCA
$dc = &$GLOBALS['TL_DCA']['tl_files'];
$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = 'name,gallery_number,protected,syncExclude,importantPartX,importantPartY,importantPartWidth,importantPartHeight;meta';

$arrFields = array(
    'gallery_number'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['gallery_number'],
        'inputType'                => 'text',
    		'eval'                     => array('tl_class'=>'w50'),
    		'sql'                      => "varchar(12) NOT NULL default ''"
    )
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);






class tl_files extends Backend
{
	
	/**
	 * Adjust the palettes
	 *
	 * @param DataContainer $dc
	 */
	public function adjustPalettes(DataContainer $dc)
	{
		if (!$dc->id)
		{
			return;
		}

		$projectDir = System::getContainer()->getParameter('kernel.project_dir');
		$blnIsFolder = is_dir($projectDir . '/' . $dc->id);

		// Remove the metadata when editing folders
		if ($blnIsFolder)
		{
			PaletteManipulator::create()
				->removeField('meta')
				->applyToPalette('default', $dc->table)
			;
		}

		// Only show the important part fields for images
		if ($blnIsFolder || !in_array(strtolower(substr($dc->id, strrpos($dc->id, '.') + 1)), System::getContainer()->getParameter('contao.image.valid_extensions')))
		{
			PaletteManipulator::create()
				->removeField(array('importantPartX', 'importantPartY', 'importantPartWidth', 'importantPartHeight', 'gallery_number'))
				->applyToPalette('default', $dc->table)
			;
		}
	}

}
