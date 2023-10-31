<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-glide
 */

namespace Bcs\GlideBundle;

class ContentGlideStop extends \ContentText
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_glide_stop';


	/**
	 * Generate the content element
	 */
	public function compile()
	{
		parent::compile();
	}
}
