<?php
/**
 * Craft Dynamic Fields plugin for Craft CMS 3.x
 *
 * Populate Craft fields with dynamic data.
 *
 * @link      https://lj.io
 * @copyright Copyright (c) 2018 Lewis Jenkins
 */

namespace lewisjenkins\craftdynamicfields;

use lewisjenkins\craftdynamicfields\fields\Checkboxes as CheckboxesField;
use lewisjenkins\craftdynamicfields\fields\Multiselect as MultiselectField;
use lewisjenkins\craftdynamicfields\fields\Dropdown as DropdownField;
use lewisjenkins\craftdynamicfields\fields\Radiobuttons as RadiobuttonsField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

class CraftDynamicFields extends Plugin
{
    public static $plugin;
    
    public $schemaVersion = '1.0.0';

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = CheckboxesField::class;
                $event->types[] = MultiselectField::class;
                $event->types[] = DropdownField::class;
                $event->types[] = RadiobuttonsField::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'craft-dynamic-fields',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

}
