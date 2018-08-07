<?php

/**
 * Nette-framework SEO Extension
 *
 * @author Milan Kyncl <kontakt@milankyncl.cz>
 * @copyright Milan Kyncl, 2018
 */

namespace MilanKyncl\Nette\SEO\Components\MetaTags;

use Nette\Utils\Html;
use Nette\Application\UI\Control;
use MilanKyncl\Nette\SEO\SEOResolver;

/**
 * Class MetaTags
 *
 * @package Core\SEO
 */

class MetaTags extends Control {

	/** @var SEOResolver */

	private $resolver;

	/**
	 * Set Resolver
	 *
	 * @param SEOResolver $resolver
	 */

	public function setResolver(SEOResolver $resolver) {

		$this->resolver = $resolver;
	}

	/**
	 * Render component
	 */

	public function render() {

		$tags = Html::el();

		// Custom tags

		foreach($this->resolver->getCustomTags() as $name => $content)
			$tags->addHtml(Html::el('meta', [ 'name' => $name, 'content' => $content ]));

		// Title tag

		$tags->addHtml(Html::el('title')->addText($this->resolver->getTitle()));

		// SEO Tags

		foreach($this->resolver->getSEOTags() as $property => $content)
			$tags->addHtml(Html::el('meta', [ 'property' => $property, 'content' => $content ]));

		// Render the result

		echo $tags;
	}

}