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
	    
	    /*
        parent::compile();
        
        
        $objTemplate = new \FrontendTemplate($this->thumbTpl ?: 'gallery_glide_thumbnails');
		$objTemplate->setData($this->arrData);
		$objTemplate->body = $body;
		$objTemplate->headline = $this->headline; // see #1603

		$this->Template->thumbs = $objTemplate->parse();
		
		*/

        
        
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
				break;

			case 'random':
				shuffle($images);
				$this->Template->isRandomOrder = true;
				break;
		}

		$images = array_values($images);

		// Limit the total number of items (see #2652)
		if ($this->numberOfItems > 0)
		{
			$images = \array_slice($images, 0, $this->numberOfItems);
		}

		$offset = 0;
		$total = \count($images);
		$limit = $total;

		// Paginate the result of not randomly sorted (see #8033)
		if ($this->perPage > 0 && $this->sortBy != 'random')
		{
			// Get the current page
			$id = 'page_g' . $this->id;
			$page = (int) (Input::get($id) ?? 1);

			// Do not index or cache the page if the page number is outside the range
			if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
			{
				throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
			}

			// Set limit and offset
			$offset = ($page - 1) * $this->perPage;
			$limit = min($this->perPage + $offset, $total);

			$objPagination = new Pagination($total, $this->perPage, Config::get('maxPaginationLinks'), $id);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}

		$colwidth = floor(100/$this->perRow);
		$body = array();

		$figureBuilder = \System::getContainer()
			->get('contao.image.studio')
			->createFigureBuilder()
			->setSize($this->size)
			->setLightboxGroupIdentifier('lb' . $this->id)
			->enableLightbox($this->fullsize);

		// Rows
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
				}
				else
				{
					$cellData = array('addImage' => false);
				}

				// Add column width
				$cellData['colWidth'] = $colwidth . '%';

				$body[$i][$j] = (object) $cellData;
			}
		}

		$request = \System::getContainer()->get('request_stack')->getCurrentRequest();

		// Always use the default template in the back end
		if ($request && \System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$this->galleryTpl = '';
		}

		$objTemplate = new \FrontendTemplate($this->galleryTpl ?: 'gallery_default');
		$objTemplate->setData($this->arrData);
		$objTemplate->body = $body;
		$objTemplate->headline = $this->headline; // see #1603

		$this->Template->images = $objTemplate->parse();
		
		
		$objTemplate = new \FrontendTemplate($this->thumbTpl ?: 'gallery_glide_thumbnails');
		$objTemplate->setData($this->arrData);
		$objTemplate->body = $body;
		$objTemplate->headline = $this->headline; // see #1603

		$this->Template->thumbnails = $objTemplate->parse();
        
        
        
        
        
        

        // Slider configuration
		$this->Template->config = $this->glide_type . ',' . $this->starting_slide . ',' . $this->slides_to_show . ',' . $this->slide_padding . ',' . $this->autoplay . ',' . $this->pause_on_hover . ',' . $this->ani_duration . ',' . $this->keyboard . ',' . $this->peek;
	}
}
