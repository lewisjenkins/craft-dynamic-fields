<?php

namespace Craft;

class Lj_DynamicFields_CheckboxesFieldType extends BaseFieldType
{
	public function getName()
	{
		return Craft::t('Checkboxes (dynamic)');
	}

	public function getInputHtml($name, $values)
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

		$values = array();

			foreach ($options as $option) :
				if (!empty($option['default'])) :
					$values[] = $option['value'];
				endif;
			endforeach;
		endif;

		return craft()->templates->render('_includes/forms/checkboxGroup', array(
			'name' => $name,
			'values' => $values,
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
        return AttributeType::Mixed;
    }

	public function getSettingsHtml()
    {
        return craft()->templates->render('lj_dynamicfields/settings/checkboxes', array(
			'name' => 'json',
			'settings' => $this->getSettings()
        ));
    }
}
