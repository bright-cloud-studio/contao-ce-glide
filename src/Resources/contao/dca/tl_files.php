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

$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = 'name,gallery_name,protected,syncExclude,importantPartX,importantPartY,importantPartWidth,importantPartHeight;meta'
//$GLOBALS['TL_DCA']['tl_content']['palettes']['glide_stop'] = '{type_legend},type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{invisible_legend:hide},invisible,start,stop';

//$GLOBALS['TL_DCA']['tl_content']['palettes']['glide_gallery'] = '{type_legend},type,headline;{source_legend},multiSRC,useHomeDir,sortBy,metaIgnore;{image_legend},size,thumb_size,fullsize;{glide_legend},glide_type,autoplay,slides_to_show,starting_slide,slide_padding,peek,pause_on_hover,ani_duration,keyboard;{template_legend:hide},galleryTpl,thumb_template,customTpl;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';

//$GLOBALS['TL_DCA']['tl_content']['fields']['multiSRC']['eval']['isGallery'] = true;
//$GLOBALS['TL_DCA']['tl_content']['fields']['multiSRC']['eval']['isSortable'] = true;




$arrFields = array(
    'gallery_number'            => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_files']['gallery_number'],
        'inputType'                => 'text',
    		'eval'                     => array('tl_class'=>'w50'),
    		'sql'                      => "varchar(12) NOT NULL default ''"
    )
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);
