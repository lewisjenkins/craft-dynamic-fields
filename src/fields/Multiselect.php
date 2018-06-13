<?php

namespace lewisjenkins\craftdynamicfields\fields;

use lewisjenkins\craftdynamicfields\CraftDynamicFields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

class Multiselect extends Field
{
     
    public $multiselectOptions = '';
    public $fieldSettings = '';

    public static function displayName(): string
    {
        return Craft::t('craft-dynamic-fields', 'Multi-select (dynamic)');
    }

    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'craft-dynamic-fields/_components/fields/Multiselect_settings',
            [
                'field' => $this,
            ]
        );
    }

    public function getInputHtml($value, ElementInterface $element = null): string
    {

		$view = Craft::$app->getView();
		$templateMode = $view->getTemplateMode();
		$view->setTemplateMode($view::TEMPLATE_MODE_SITE);
	
		$variables['element'] = $element;
		$variables['this'] = $this;
		
		$options = json_decode('[' . $view->renderString($this->multiselectOptions, $variables) . ']', true);
		$blah = json_decode('{' . $view->renderString($this->fieldSettings, $variables) . '}', true);
		
		$view->setTemplateMode($templateMode);
		
		foreach ($options as $key => $option) :

		    if ($this->isFresh($element) ) :
		    	if (!empty($option['default'])) :
		    		$value[] = $option['value'];
				endif;
			endif;
			
			// unset($options[$key]['selected']);

		endforeach; 
	
        return Craft::$app->getView()->renderTemplate('craft-dynamic-fields/_includes/forms/multiselect', [
            'name' => $this->handle,
            'values' => $value,
            'options' => $options,
            'size' => ($blah['size'] ?? '4')
        ]);
    }
}
