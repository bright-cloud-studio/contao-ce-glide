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

	/* Template @var string */
	protected $strTemplate = 'ce_glide_stop';

	/* Generate the content element */
	public function compile()
	{
		$request = \System::getContainer()->get('request_stack')->getCurrentRequest();

		if ($request && \System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$this->strTemplate = 'be_wildcard';
			$this->Template = new \BackendTemplate($this->strTemplate);
		}

		// Previous and next labels
		$this->Template->previous = $GLOBALS['TL_LANG']['MSC']['previous'];
		$this->Template->next = $GLOBALS['TL_LANG']['MSC']['next'];
	}
}
