<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-glide
 */

namespace Bcs\GlideBundle;

use Contao\ContentText;
use Contao\System;

class ContentGlideStart extends ContentText
{
	/* Template @var string */
	protected $strTemplate = 'ce_glide_start';

	/* Generate the content element */
	public function compile()
	{
		$request = System::getContainer()->get('request_stack')->getCurrentRequest();

		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$this->strTemplate = 'be_wildcard';
			$this->Template = new \BackendTemplate($this->strTemplate);
			$this->Template->title = $this->headline;
		}

		// Slider configuration
		$this->Template->config = $this->glide_type . ',' . $this->starting_slide . ',' . $this->slides_to_show . ',' . $this->slide_padding . ',' . $this->autoplay . ',' . $this->pause_on_hover . ',' . $this->ani_duration . ',' . $this->keyboard . ',' . $this->peek;
	}
}
