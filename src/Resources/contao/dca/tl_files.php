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
    'glide_name'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['glide_name'],
        'inputType'                => 'text',
        'eval'                     => array('tl_class'=>'w50'),
        'sql'                      => "varchar(12) NOT NULL default ''"
    ),
    'glide_number'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['glide_number'],
        'inputType'                => 'text',
        'eval'                     => array('tl_class'=>'w50'),
        'sql'                      => "varchar(12) NOT NULL default ''"
    ),
    'glide_new'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['glide_new'],
        'inputType'                => 'radio',
        'options'                  => array('yes' => 'Yes', 'no' => 'No'),
        'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
        'sql'                      => "varchar(32) NOT NULL default ''"
    )
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);
