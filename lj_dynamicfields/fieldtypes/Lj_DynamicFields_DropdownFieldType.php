<?php

namespace Craft;

class Lj_DynamicFields_DropdownFieldType extends BaseFieldType
{
	public function getName()
	{
		return Craft::t('Dropdown (dynamic)');
	}

	public function getInputHtml($name, $value)
	{
		$oldMode = craft()->templates->getTemplateMode();
		craft()->templates->setTemplateMode(TemplateMode::Site);

		$variables = array();
		foreach (craft() -> globals -> getAllSets() as $globalSet) :
			$variables[$globalSet->handle] = $globalSet;
		endforeach;

		$variables['element'] = $this->element;
		$variables['model'] = $this->model;

		$options = json_decode('[' . craft()->templates->renderString($this->getSettings()->json, $variables) . ']', true);
		craft()->templates->setTemplateMode($oldMode);

		if ($this->isFresh()) :
			foreach ($options as $option) :
				if (!empty($option['default'])) :
					$value = $option['value'];
					break;
				endif;
			endforeach;
		endif;

		return craft()->templates->render('_includes/forms/select', array(
			'name' => $name,
			'value' => $value,
			'options' => $options
		));
	}

	protected function defineSettings()
    {
        return array(
            'json' => array(AttributeType::String)
        );
    }

	public function defineContentAttribute()
    {
        return AttributeType::String;
    }

	public function getSettingsHtml()
    {
        return craft()->templates->render('lj_dynamicfields/settings/dropdown', array(
			'name' => 'json',
			'settings' => $this->getSettings()
        ));
    }
}
