<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see        https://github.com/bright-cloud-studio/contao-ce-glide
 */

use Contao\Controller;
use Contao\Config; // Needed for Contao 4.13
use Contao\System; // Needed for Contao 5.x

// Get our default 'tl_files' DCA
$dc = &$GLOBALS['TL_DCA']['tl_files'];

$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = 'name,glide_number,glide_name,glide_new,glide_featured,glide_example_img,protected,syncExclude,importantPartX,importantPartY,importantPartWidth,importantPartHeight;meta';

// Retrieve the valid image types in a backward-compatible way
$validImageTypes = class_exists(System::class) 
    ? System::getConfig()->get('validImageTypes') // Contao 5.x
    : Config::get('validImageTypes'); // Contao 4.13

$arrFields = array(
    'glide_name' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_files']['glide_name'],
        'inputType'    => 'text',
        'eval'         => array('tl_class' => 'w50'),
        'sql'          => "varchar(255) BINARY NOT NULL default ''"
    ),
    'glide_number' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_files']['glide_number'],
        'inputType'    => 'text',
        'eval'         => array('tl_class' => 'w50'),
        'sql'          => "varchar(255) BINARY NOT NULL default ''"
    ),
    'glide_new' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_files']['glide_new'],
        'inputType'    => 'radio',
        'options'      => array('yes' => 'Yes', 'no' => 'No'),
        'eval'         => array('tl_class' => 'w50'),
        'sql'          => "varchar(32) NOT NULL default ''"
    ),
    'glide_featured' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_files']['glide_featured'],
        'inputType'    => 'radio',
        'options'      => array('yes' => 'Yes', 'no' => 'No'),
        'eval'         => array('tl_class' => 'w50'),
        'sql'          => "varchar(32) NOT NULL default ''"
    ),
    'glide_example_img' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_files']['glide_example_img'],
        'exclude'      => true,
        'inputType'    => 'fileTree',
        'eval'         => array(
            'filesOnly'  => true,
            'extensions' => $validImageTypes, // Now properly retrieved
            'fieldType'  => 'radio',
            'tl_class'   => 'w50'
        ),
        'sql'          => "binary(16) NULL"
    )
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);
