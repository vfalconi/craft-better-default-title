<?php
/**
 * Better Default Title plugin for Craft CMS 3.x
 *
 * Prescriptive plugin for default Asset titles.
 *
 * @author		Vince Falconi
 * @package		BetterDefaultTitle
 * @since			1.0.0
 * @link			https://tattooed.dev
 */

namespace vfalconi\betterdefaulttitle;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\elements\Asset;
use craft\events\AssetEvent;
use craft\helpers\StringHelper;

use yii\base\Event;

class BetterDefaultTitle extends Plugin
{
	public static $plugin;
	public $schemaVersion = '1.0.0';
	public $hasCpSettings = false;
	public $hasCpSection = false;

	public function init()
	{
		parent::init();
		self::$plugin = $this;

		Event::on(Asset::class, Asset::EVENT_BEFORE_HANDLE_FILE, function(AssetEvent $event) {
			$asset = $event->asset;
			$asset->title = StringHelper::toKebabCase($asset->getFilename(false)).' ('.strtoupper($asset->extension).')';
		});

		Craft::info(
			Craft::t(
				'better-default-title',
				'{name} plugin loaded',
				[ 'name' => $this->name ]
			),
			__METHOD__
		);
	}
}
