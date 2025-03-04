<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see        https://github.com/bright-cloud-studio/contao-ce-glide
 */


use Contao\Controller;
use Contao\Config;

// Get our default 'tl_content' DCA
$dc = &$GLOBALS['TL_DCA']['tl_files'];
$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = 'name,glide_number,glide_name,glide_new,glide_featured,glide_example_img,protected,syncExclude,importantPartX,importantPartY,importantPartWidth,importantPartHeight;meta';
$arrFields = array(
    'glide_name'               => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['glide_name'],
        'inputType'                => 'text',
        'eval'                     => array('tl_class'=>'w50'),
        'sql'                      => "varchar(255) BINARY NOT NULL default ''"
    ),
    'glide_number'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['glide_number'],
        'inputType'                => 'text',
        'eval'                     => array('tl_class'=>'w50'),
        'sql'                      => "varchar(255) BINARY NOT NULL default ''"
    ),
    'glide_new'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['glide_new'],
        'inputType'                => 'radio',
        'options'                  => array('yes' => 'Yes', 'no' => 'No'),
        'eval'                     => array('tl_class'=>'w50'),
        'sql'                      => "varchar(32) NOT NULL default ''"
    ),
    'glide_featured'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['glide_featured'],
        'inputType'                => 'radio',
        'options'                  => array('yes' => 'Yes', 'no' => 'No'),
        'eval'                     => array('tl_class'=>'w50'),
        'sql'                      => "varchar(32) NOT NULL default ''"
    ),
    'glide_example_img'         => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['glide_example_img'],
        'exclude'                  => true,
        'inputType'                => 'fileTree',
        'eval'                     => array('filesOnly'=>true, 'extensions'=>Config::getInstance()->get('validImageTypes'), 'fieldType'=>'radio', 'tl_class'=>'w50'),
        'sql'                      => "binary(16) NULL"
    )
);
$dc['fields'] = array_merge($dc['fields'], $arrFields);
