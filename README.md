### LJ Dynamic Fields plugin for Craft CMS

A simple plugin for populating Craft fields with dynamic data.

**Installation**

1. Unzip file 
2. Place `lj_dynamicfields` directory into your `craft/plugins` directory
3. Install plugin in the Craft Control Panel under Settings > Plugins

**Useage**

This plugin adds the following fieldtypes:

+ Checkboxes (dynamic)
+ Dropdown (dynamic)
+ Multi-select (dynamic)
+ Radio Buttons (dynamic)

You can populate the options for each fieldtye using JSON, like this :

    { "value":"jim" , "label":"Jim Beam" },
    { "value":"jack" , "label":"Jack Daniels" , "default":true },
    { "value":"mark" , "label":"Maker's Mark" }
	
No big deal, right? But the real power of this plugin is it's ability to use Twig logic :

    {% for drink in craft.entries.section('drinks') %}
        { "value":"{{ drink.id }}" , "label":"{{ drink | raw }}"
            {% if drink.slug == 'jack' %} , "default":true{% endif %}
        }{% if not loop.last %},{% endif %}
    {% endfor %}
	
Because you're able to use Twig, you can pull in all sorts of useful data. You can even include a template :

    {% include '_dynamicfields/sections' ignore missing %}
	
Example code for `/craft/templates/_dynamicfields/sections.html`

	{% for section in craft.sections.getAllSections() %}
        { "value":"{{ section.id }}" , "label":"{{ section | raw }}" }
        {% if not loop.last %},{% endif %}
    {% endfor %}
	
*Basically, any data that can be manipulated in your templates is now available for selection within your fields.*

Still confused? Here is a screengrab :

![My image](https://raw.github.com/lewisjenkins/craft-lj-dynamicfields/master/screengrab.png)

**Version 0.5**

+ Improved: Globals can now be directly referenced by handle.

**Version 0.4.1**

+ Improved: multi-type fields are now saved to db as 'text' rather than varchar(255) to allow for large arrays.

**Version 0.4**

+ Added: Radio Buttons fieldtype

**Version 0.3**

+ Added: Checkboxes fieldtype

**Version 0.2**

+ Added: Multi-select fieldtype

**Version 0.1**

+ Added: Dropdown fieldtype
+ Initial release

**Todo**

+ Add more fieldtypes :)

**Tested on**

+ All versions of Craft (including latest Craft 2.1)
