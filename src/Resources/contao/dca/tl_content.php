<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see        https://github.com/bright-cloud-studio/contao-ce-glide
 */

use Contao\Controller;
use Contao\DataContainer;
use Contao\System;
use Contao\Config; // Needed for Contao 4.13

// Get our default 'tl_content' DCA
$dc = &$GLOBALS['TL_DCA']['tl_content'];

$GLOBALS['TL_DCA']['tl_content']['palettes']['glide_start'] = '{type_legend},type,headline;{glide_legend},glide_type,autoplay,slides_to_show,starting_slide,slide_padding,peek,pause_on_hover,ani_duration,keyboard;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['glide_stop'] = '{type_legend},type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['glide_gallery'] = '{type_legend},type,headline,description;{source_legend},multiSRC,useHomeDir,sortBy,metaIgnore;{image_legend},size,thumb_size,fullsize;{glide_legend},glide_type,autoplay,slides_to_show,starting_slide,slide_padding,peek,pause_on_hover,ani_duration,keyboard;{template_legend:hide},galleryTpl,thumb_template,customTpl;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';

//$GLOBALS['TL_DCA']['tl_content']['fields']['multiSRC']['eval']['isGallery'] = true;
$GLOBALS['TL_DCA']['tl_content']['fields']['multiSRC']['eval']['isSortable'] = true;

$arrFields = array(
    'description' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_content']['description'],
        'eval'         => array('style'=>'height:60px', 'rte'=>'tinyMCE', 'tl_class'=>'clr long'),
        'explanation'  => 'insertTags',
        'sql'          => "text NULL"
    ),
    'glide_type' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_content']['glide_type'],
        'inputType'    => 'select',
        'options'      => array('slider' => 'Slider', 'carousel' => 'Carousel'),
        'eval'         => array('mandatory'=>true, 'tl_class'=>'w50'),
        'sql'          => "varchar(32) NOT NULL default 'slider'"
    ),
    'starting_slide' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_content']['starting_slide'],
        'inputType'    => 'text',
        'eval'         => array('tl_class'=>'w50'),
        'sql'          => "varchar(12) NOT NULL default ''"
    ),
    'slides_to_show'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['slides_to_show'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default ''"
    ),
    'slide_padding'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['slide_padding'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default ''"
    ),
    'autoplay'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['autoplay'],
        'inputType'                => 'select',
		'options'                  => array('false' => 'False', '500' => '500ms', '1000' => '1000ms', '1500' => '1500ms', '2000' => '2000ms', '2500' => '2500ms', '3000' => '3000ms'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'false'"
    ),
    'pause_on_hover' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_content']['pause_on_hover'],
        'inputType'    => 'select',
        'options'      => array('true' => 'True', 'false' => 'False'),
        'eval'         => array('mandatory'=>true, 'tl_class'=>'w50'),
        'sql'          => "varchar(32) NOT NULL default 'true'"
    ),
    'ani_duration' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_content']['ani_duration'],
        'inputType'    => 'text',
        'eval'         => array('tl_class'=>'w50'),
        'sql'          => "varchar(12) NOT NULL default ''"
    ),
    'keyboard' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_content']['keyboard'],
        'inputType'    => 'select',
        'options'      => array('true' => 'True', 'false' => 'False'),
        'eval'         => array('mandatory'=>true, 'tl_class'=>'w50'),
        'sql'          => "varchar(32) NOT NULL default 'true'"
    ),
    'peek' => array(
        'label'        => &$GLOBALS['TL_LANG']['tl_content']['peek'],
        'inputType'    => 'text',
        'eval'         => array('tl_class'=>'w50'),
        'sql'          => "varchar(12) NOT NULL default ''"
    ),
    'thumb_size' => array(
        'label'        => &$GLOBALS['TL_LANG']['MSC']['thumb_size'],
        'inputType'    => 'imageSize',
        'reference'    => &$GLOBALS['TL_LANG']['MSC'],
        'options_callback' => static function () {
            if (class_exists(System::class)) {
                // Contao 5.3
                return System::getContainer()->get('contao.image.sizes')->getOptionsForUser(
                    System::getContainer()->get('security.helper')->getUser()
                );
            } else {
                // Contao 4.13
                return System::getImageSizes();
            }
        },
        'eval'         => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50 clr'),
        'sql'          => "varchar(128) COLLATE ascii_bin NOT NULL default ''"
    ),
    
    'thumb_template' => array(
        'inputType'    => 'select',
        'options_callback' => static function () {
            return method_exists(Controller::class, 'getTemplateGroup') 
                ? Controller::getTemplateGroup('gallery_') // Works in both Contao 4.13 & 5.3
                : [];
        },
        'eval'         => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
        'sql'          => "varchar(64) COLLATE ascii_bin NOT NULL default ''"
    ),
    'multiSRC' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['multiSRC'],
        'exclude'                 => true,
        'inputType'               => 'fileTree',
        'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'orderField'=>'orderSRC', 'files'=>true, 'mandatory'=>true),
        'sql'                     => "blob NULL",
        'load_callback' => array
        (
            array('tl_content_bcs', 'setMultiSrcFlags')
        )
    ),
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);

class tl_content_bcs extends tl_content
{
    public function setMultiSrcFlags($varValue, DataContainer $dc)
    {
        if ($dc->activeRecord) {
            switch ($dc->activeRecord->type) {
                case 'gallery':
                        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
                    
                    // Use Contao 5.3 method if available, fallback to Contao 4.13
                    if (class_exists(System::class)) {
                        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] =
                            System::getContainer()->getParameter('contao.image.valid_extensions'); // Contao 5.3
                    } else {
                        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] =
                            Config::get('validImageTypes'); // Contao 4.13
                    }
                    break;
                case 'glide_gallery':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
                    
                    // Use Contao 5.3 method if available, fallback to Contao 4.13
                    if (class_exists(System::class)) {
                        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] =
                            System::getContainer()->getParameter('contao.image.valid_extensions'); // Contao 5.3
                    } else {
                        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] =
                            Config::get('validImageTypes'); // Contao 4.13
                    }
                    break;

                case 'downloads':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isDownloads'] = true;
                    
                    if (class_exists(System::class)) {
                        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] =
                            System::getContainer()->getParameter('contao.upload.valid_extensions'); // Contao 5.3
                    } else {
                        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] =
                            Config::get('allowedDownload'); // Contao 4.13
                    }
                    break;
            }
        }

        return $varValue;
    }
}
