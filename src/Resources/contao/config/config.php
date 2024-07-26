<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-glide
 */
  
   array_insert($GLOBALS['TL_CTE']['glide'], -1, array
    (
        'glide_start' => 'Bcs\GlideBundle\ContentGlideStart',
        'glide_stop' => 'Bcs\GlideBundle\ContentGlideStop',
        'glide_gallery' => 'Bcs\GlideBundle\ContentGlideGallery'
    ));

$GLOBALS['TL_CTE']['glide']['glide_start'] = 'Bcs\GlideBundle\ContentGlideStart';
$GLOBALS['TL_CTE']['glide']['glide_stop'] = 'Bcs\GlideBundle\ContentGlideStop';
$GLOBALS['TL_CTE']['glide']['glide_gallery'] = 'Bcs\GlideBundle\ContentGlideGallery;




    // Declare both of our new Content Elements as wrappers so we get the cool indenting in Content > Articles
    $GLOBALS['TL_WRAPPERS']['start'][] = 'glide_start';
    $GLOBALS['TL_WRAPPERS']['stop'][] = 'glide_stop';

?>
