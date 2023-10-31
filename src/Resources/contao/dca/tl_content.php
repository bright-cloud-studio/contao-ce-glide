<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-glide
 */

// Get our default 'tl_content' DCA
$dc = &$GLOBALS['TL_DCA']['tl_content'];

$GLOBALS['TL_DCA']['tl_content']['palettes']['glide'] = '{type_legend},type,headline;{text_legend},text,buttonLink;{image_legend},addImage;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';

$arrFields = array(
    'buttonLink'                => array(
        'label'                => &$GLOBALS['TL_LANG']['tl_content']['buttonLink'],
        'inputType'            => 'text',
        'eval'                 => array('mandatory'=>false, 'maxlength'=>255, 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'personal', 'tl_class'=>'w50'),
        'sql'                  => "varchar(255) NOT NULL default ''"
    )
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);
