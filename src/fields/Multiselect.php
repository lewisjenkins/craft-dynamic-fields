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
    public $fieldSettings = ''; // legacy
    public $columnType = 'text';
    public $fieldHeight = 0;

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
    
    public function getContentColumnType(): string
    {
        return $this->columnType;
    }

    public function getInputHtml($value, ElementInterface $element = null): string
    {

		$view = Craft::$app->getView();
		$templateMode = $view->getTemplateMode();
		$view->setTemplateMode($view::TEMPLATE_MODE_SITE);
	
		$variables['element'] = $element;
		$variables['this'] = $this;
		
		$options = json_decode('[' . $view->renderString($this->multiselectOptions, $variables) . ']', true);
		
		$view->setTemplateMode($templateMode);
		
		if ($this->isFresh($element) ) :
			foreach ($options as $key => $option) :
		    	if (!empty($option['default'])) :
		    		$value[] = $option['value'];
				endif;
			endforeach;
		endif;
	
        return Craft::$app->getView()->renderTemplate('craft-dynamic-fields/_includes/forms/multiselect', [
            'name' => $this->handle,
            'values' => (is_string($value) ? json_decode($value) : $value),
            'options' => $options,
            'size' => ($this->fieldHeight > 0 ? $this->fieldHeight : count($options))
        ]);
    }
}
