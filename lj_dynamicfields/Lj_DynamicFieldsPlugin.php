<?php
namespace Craft;

class Lj_DynamicFieldsPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('LJ Dynamic Fields');
    }

    function getVersion()
    {
        return '0.6';
    }

    function getDeveloper()
    {
        return 'Lewis Jenkins';
    }

    function getDeveloperUrl()
    {
        return 'http://lewisjenkins.co.uk';
    }

    /**
     * Require Craft 2.6.2778
     *
     * @throws Exception
     */
    public function onBeforeInstall()
    {
      if (version_compare(craft()->getVersion().'.'.craft()->getBuild(), '2.6.2778', '<'))
      {
        throw new Exception('LJ Dynamic Fields 0.6+ requires Craft CMS 2.6.2778+ in order to run.');
      }
    }
}
