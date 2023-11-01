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

$GLOBALS['TL_DCA']['tl_content']['palettes']['glide_start'] = '{type_legend},type,headline;{glide_legend},glide_type,starting_slide,slides_to_show,slide_padding,autoplay,pause_on_hover,ani_duration;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['glide_stop'] = '{type_legend},type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{invisible_legend:hide},invisible,start,stop';
    
$arrFields = array(
    'glide_type'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['glide_type'],
        'inputType'                => 'select',
		'options'                  => array('slider' => 'Slider', 'carousel' => 'Carousel'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'slider'"
    ),
    'starting_slide'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['starting_slide'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default ''"
    ),
    'slides_to_show'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['slides_to_show'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default ''"
    )
    'slide_padding'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['slide_padding'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default ''"
    )
    'autoplay'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['autoplay'],
        'inputType'                => 'select',
		'options'                  => array('false' => 'False', '500' => '500ms', '1000' => '1000ms', '1500' => '1500ms', '2000' => '2000ms', '2500' => '2500ms', '3000' => '3000ms'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'false'"
    ),
    'pause_on_hover'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['pause_on_hover'],
        'inputType'                => 'select',
		'options'                  => array('true' => 'True', 'false' => 'False'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'true'"
    ),
    'ani_duration'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['ani_duration'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default ''"
    )
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);
