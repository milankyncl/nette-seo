<?php

/**
 * Nette-framework SEO Extension
 *
 * @author Milan Kyncl <kontakt@milankyncl.cz>
 * @copyright Milan Kyncl, 2018
 */

namespace MilanKyncl\Nette\SEO;

use Nette\SmartObject;
use Nette\InvalidArgumentException;

/**
 * Class SEOResolver
 *
 * @package Core\SEO
 */

class SEOResolver {

	use SmartObject;

	/** @var null Site title */

	private $title = null;

	/** @var null Site name */

	private $site_name = null;

	/** @var null Site description */

	private $description = null;

	/** @var null Site description */

	private $separator = null;

	/** @var array Custom meta tags */

	private $customTags = [];

	/** @var array SEO Meta tags */

	private $metaTags = [

		'og:title'              => null,
		'og:description'        => null,
		'og:image'              => null,
		'og:image:width'        => null,
		'og:image:height'       => null,
		'og:url'                => null,
		'og:type'               => null,
		'og:site_name'          => null,
		'og:locale'             => null,

		'twitter:title'         => null,
		'twitter:description'   => null,
		'twitter:card'          => 'summary_large_image',
		'twitter:image'         => null,
		'twitter:site'          => null,
		'twitter:creator'       => null
	];

	/**
	 * SEOResolver constructor.
	 *
	 * @param array $config
	 */

	public function __construct(array $config = []) {

		$this->site_name    = $config['site_name'];
		$this->separator    = $config['separator'];
		$this->description  = $config['description'];

		foreach($config['customTags'] as $name => $content) {

			$this->setTag($name, $content, true);
		}

		$this->setTag([ 'og:type' ], $config['type']);
		$this->setTag([ 'og:title', 'twitter:title' ], $this->getTitle());
		$this->setTag([ 'og:description', 'twitter:description' ], $config['description']);
		$this->setImageUrl($config['image']);
		$this->setTag([ 'og:url' ], (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	}

	/**
	 * Set meta tag
	 *
	 * @param $names array|string
	 * @param $content
	 */

	public function setTag($names, $content, $isCustom = false) {

		if(!is_array($names))
			$names = [ $names ];

		foreach($names as $name) {

			if($isCustom) {

				$this->customTags[$name] = $content;

			} else {

				if(!key_exists($name, $this->metaTags))
					throw new InvalidArgumentException('SEO Tag ' . $name . ' is not allowed.');

				$this->metaTags[$name] = $content;
			}
		}
	}

	/**
	 * Set page title
	 *
	 * @param $title
	 */

	public function setTitle($title) {

		$this->title = $title;

		$this->setTag([ 'og:title', 'twitter:title'], $this->getTitle());
	}

	/**
	 * Set page description
	 *
	 * @param $description
	 */

	public function setDescription($description) {

		$this->description = $description;

		$this->setTag([ 'og:description', 'twitter:description'], $description);
	}

	/**
	 * Set page description
	 *
	 * @param $url
	 */

	public function setImageUrl($url, $width = null, $height = null) {

		if(file_exists($url)) {

			bdump('file exists');
		}

		$this->setTag([ 'og:image', 'twitter:image' ], $url);

		$this->setTag('og:image:width', $width);
		$this->setTag('og:image:height', $height);
	}

	/**
	 * Get custom meta tags
	 */

	public function getCustomTags() {

		return $this->customTags;
	}

	/**
	 * Get meta tags
	 */

	public function getSEOTags() {

		return $this->seoTags;
	}

	/**
	 * Get Page title
	 */

	public function getTitle() {

		return (($this->title != null) ? $this->title . ' ' . $this->separator . ' ' : '' ) . $this->getSiteName();
	}

	/**
	 * Get Site name
	 */

	public function getSiteName() {

		return $this->site_name;
	}

	/**
	 * Get Page description
	 */

	public function getDescription() {

		return $this->site_name;
	}

}