<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-glide
 */
  
   array_insert($GLOBALS['TL_CTE']['glide'], 0, array
    (
        'glide_start' => 'Bcs\GlideBundle\ContentGlideStart',
        'glide_stop' => 'Bcs\GlideBundle\ContentGlideStop'
    ));

?>
