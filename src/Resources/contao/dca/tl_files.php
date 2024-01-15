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


class tl_files_bcs extends tl_files
{

    public function __construct()
	{
		parent::__construct();
	}

}
