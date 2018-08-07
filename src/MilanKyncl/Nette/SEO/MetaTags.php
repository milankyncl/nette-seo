<?php


namespace MilanKyncl\Nette\SEO;

use Nette\Application\UI\Control;

/**
 * Class MetaComponent
 *
 * @package MilanKyncl\Nette\SEO
 */

class MetaTags extends Control {

	/**
	 * Render component
	 */

	public function render() {

		$template = $this->template;

		$template->setFile(__DIR__ . '/templates/metaTags.latte');

		$template->render();

	}

}