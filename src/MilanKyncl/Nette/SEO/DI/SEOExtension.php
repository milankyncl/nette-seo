<?php

/**
 * Nette-framework SEO Extension
 *
 * @author Milan Kyncl <kontakt@milankyncl.cz>
 * @copyright Milan Kyncl, 2018
 */

namespace MilanKyncl\Nette\SEO\DI;

use Nette\DI\CompilerExtension;
use MilanKyncl\Nette\SEO\SEOResolver;
use MilanKyncl\Nette\SEO\Components\MetaTags\MetaTags;

/**
 * Class SEOExtension
 *
 * @package MilanKyncl\Nette\SEO\DI
 */

class SEOExtension extends CompilerExtension {

	/** Default settings */

	const DEFAULT_CONFIG = [
		'site_name'     => null,
		'description'   => null,
		'type'          => 'website',
		'image'         => null,
		'separator'     => '-',
		'customTags'    => []
	];

	/**
	 * Load configuration method.
	 */

	public function loadConfiguration() {

		$config = $this->getConfig() + self::DEFAULT_CONFIG;

		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('resolver'))
		        ->setFactory(SEOResolver::class, [
		        	'config' => $config
                ]);

		$builder->addDefinition($this->prefix('metaTags'))
		        ->setFactory(MetaTags::class);

	}

}