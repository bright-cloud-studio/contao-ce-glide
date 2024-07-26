<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Glide
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-glide
 */

namespace Bcs\GlideBundle;

class ContentGlideGallery extends \Contao\ContentGallery
{
	/* Template @var string */
	protected $strTemplate = 'ce_glide_gallery';

	/* Generate the content element */
	public function compile()
	{

        $images = array();
		$projectDir = \System::getContainer()->getParameter('kernel.project_dir');

		$objFiles = $this->objFiles;

		// Get all images
		while ($objFiles->next())
		{
			// Continue if the files has been processed or does not exist
			if (isset($images[$objFiles->path]) || !file_exists($projectDir . '/' . $objFiles->path))
			{
				continue;
			}

			// Single files
			if ($objFiles->type == 'file')
			{
				$objFile = new \File($objFiles->path);

				if (!$objFile->isImage)
				{
					continue;
				}

				$row = $objFiles->row();
				$row['mtime'] = $objFile->mtime;

				// Add the image
				$images[$objFiles->path] = $row;
			}

			// Folders
			else
			{
				$objSubfiles = \FilesModel::findByPid($objFiles->uuid, array('order' => 'name'));

				if ($objSubfiles === null)
				{
					continue;
				}

				while ($objSubfiles->next())
				{
					// Skip subfolders
					if ($objSubfiles->type == 'folder')
					{
						continue;
					}

					$objFile = new \File($objSubfiles->path);

					if (!$objFile->isImage)
					{
						continue;
					}

					$row = $objSubfiles->row();
					$row['mtime'] = $objFile->mtime;

					// Add the image
					$images[$objSubfiles->path] = $row;
				}
			}
		}

		// Sort array
		switch ($this->sortBy)
		{
			default:
			case 'name_asc':
				uksort($images, static function ($a, $b): int {
					return strnatcasecmp(basename($a), basename($b));
				});
				break;

			case 'name_desc':
				uksort($images, static function ($a, $b): int {
					return -strnatcasecmp(basename($a), basename($b));
				});
				break;

			case 'date_asc':
				uasort($images, static function (array $a, array $b) {
					return $a['mtime'] <=> $b['mtime'];
				});
				break;

			case 'date_desc':
				uasort($images, static function (array $a, array $b) {
					return $b['mtime'] <=> $a['mtime'];
				});
				break;

			case 'custom':
				$images = \ArrayUtil::sortByOrderField($images, $this->orderSRC);
				break;

			case 'random':
				shuffle($images);
				$this->Template->isRandomOrder = true;
				break;
		}

		$images = array_values($images);



		$offset = 0;
		$total = \count($images);
		$limit = $total;



		$colwidth = floor(100/$this->perRow);
		$body = array();
		$bodyThumbs = array();

		$figureBuilder = \System::getContainer()
			->get('contao.image.studio')
			->createFigureBuilder()
			->setSize($this->size)
			->setLightboxGroupIdentifier('lb' . $this->id)
			->enableLightbox($this->fullsize);
			
		$figureBuilderThumb = \System::getContainer()
			->get('contao.image.studio')
			->createFigureBuilder()
			->setSize($this->thumb_size)
			->setLightboxGroupIdentifier('lb' . $this->id)
			->enableLightbox($this->fullsize);


        
		// Rows
		/*
		for ($i=$offset; $i<$limit; $i+=$this->perRow)
		{
			// Columns
			for ($j=0; $j<$this->perRow; $j++)
			{
				// Image / empty cell
				if (($j + $i) < $limit && null !== ($image = $images[$i + $j] ?? null))
				{
					$figure = $figureBuilder
						->fromId($image['id'])
						->build();

					$cellData = $figure->getLegacyTemplateData();
					$cellData['figure'] = $figure;
					
					$figureThumb = $figureBuilderThumb
						->fromId($image['id'])
						->build();

					$cellDataThumb = $figureThumb->getLegacyTemplateData();
					$cellDataThumb['figure'] = $figureThumb;
					
				}
				else
				{
					$cellData = array('addImage' => false);
				}

				// Add column width
				$cellData['colWidth'] = $colwidth . '%';

				$body[$i][$j] = (object) $cellData;
				$bodyThumbs[$i][$j] = (object) $cellDataThumb;
			}
		}
		*/
		
		foreach($images as $im) {
		    $figure = $figureBuilder
						->fromId($im['id'])
						->build();
			$cellData = $figure->getLegacyTemplateData();
			$cellData['figure'] = $figure;
			$cellData['glide_name'] = $im['glide_name'];
			$cellData['glide_number'] = $im['glide_number'];
			$cellData['glide_new'] = $im['glide_new'];
		    $body[] = (object) $cellData;
		    
		    $figureThumb = $figureBuilderThumb
						->fromId($im['id'])
						->build();
			$cellDataThumb = $figureThumb->getLegacyTemplateData();
			$cellDataThumb['figure'] = $figureThumb;
			$cellDataThumb['glide_name'] = $im['glide_name'];
			$cellDataThumb['glide_number'] = $im['glide_number'];
			$cellDataThumb['glide_new'] = $im['glide_new'];
			$bodyThumbs[] = (object) $cellDataThumb;
		    
		}
		$this->Template->tst = $bdy;
		

		$request = \System::getContainer()->get('request_stack')->getCurrentRequest();

		// Always use the default template in the back end
		if ($request && \System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$this->galleryTpl = '';
			$this->thumbTpl = '';
		}

		$objTemplate = new \FrontendTemplate($this->galleryTpl ?: 'gallery_default');
		$objTemplate->setData($this->arrData);
		$objTemplate->body = $body;
		$objTemplate->headline = $this->headline; // see #1603
		$this->Template->images = $objTemplate->parse();
		
		
		$objTemplate = new \FrontendTemplate($this->thumbTpl ?: 'gallery_glide_thumbnails');
		$objTemplate->setData($this->arrData);
		$objTemplate->body = $bodyThumbs;
		$objTemplate->headline = $this->headline; // see #1603
		$this->Template->thumbnails = $objTemplate->parse();
        
        
        
        
        
        

        // Slider configuration
		$this->Template->config = $this->glide_type . ',' . $this->starting_slide . ',' . $this->slides_to_show . ',' . $this->slide_padding . ',' . $this->autoplay . ',' . $this->pause_on_hover . ',' . $this->ani_duration . ',' . $this->keyboard . ',' . $this->peek;
	}
}
