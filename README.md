# LJ Dynamic Fields plugin for Craft CMS 3.x

Populate Craft fields with dynamic data using the power of Twig.

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

You can install the plugin via the Craft Plugin Store.

## LJ Dynamic Fields Overview

This plugin adds the following fieldtypes:

- Checkboxes (dynamic)
- Dropdown (dynamic)
- Multi-select (dynamic)
- Radio Buttons (dynamic)

![Screenshot](resources/img/1.png)

#### Simple example

You can populate the options for each fieldtye as a JSON array, like this :

    { "value":"jim", "label":"Jim Beam" },
    { "value":"jack", "label":"Jack Daniels", "default":true },
    { "value":"mark", "label":"Maker's Mark" },
    { "value":"rebel", "label":"Rebel Yell", "default":true }

This is a simple example of a checkboxes field with two of the four options selected by default.

![Screenshot](resources/img/2.png)

No big deal, right? But the real power of this plugin is the ability to dynamically populate your fields using Twig logic.

#### All entries, ordered by title

    {% for entry in craft.entries.orderBy('title').all() %}
        {{ loop.index > 1 ? ',' }} {    
            "value":"{{ entry.id }}",
            "label":"{{ entry|e }}",
            "default":{{ entry.slug == 'home' ? 'true' : 'false' }}
        }
    {% endfor %}

Here is a radiobuttons field containing all current entries, ordered by title, with the homepage selected by default.

![Screenshot](resources/img/3.png)

Because you're able to use Twig to create field options, you can do all kinds of crazy things.

#### Every first Saturday of the month

    {% for i in 1..6 %}
        {% set eventDate = now|date_modify('first saturday of +' ~ i ~ ' month') %}
        {{ loop.index > 1 ? ',' }} {
            "value":"{{ eventDate|date('Y-m-d') }}",
            "label":"{{ eventDate|date("l, jS F Y") }}"
        }
    {% endfor %}

This is a dynamic dropdown field with options for every first Saturday for the next six months.

![Screenshot](resources/img/4.png)

#### All sections

    {% for section in craft.app.sections.allSections %}
        {{ loop.index > 1 ? ',' }} {    
            "value":"{{ section.id }}",
            "label":"{{ section|e }}"
        }
    {% endfor %}

Here is a multi-select field containing all sections.

![Screenshot](resources/img/5.png)

#### Template example

You can even configure your field options in a separate template file.

    {% include '_dynamicfields/usStates.json' ignore missing %}

<!-- -->

    # templates/_dynamicfields/usStates.json

    { "label":"Alabama", "value":"AL" }, { "label":"Alaska", "value":"AK" }, { "label":"American Samoa", "value":"AS" }, { "label":"Arizona", "value":"AZ" }, { "label":"Arkansas", "value":"AR" }, { "label":"California", "value":"CA" }, { "label":"Colorado", "value":"CO" }, { "label":"Connecticut", "value":"CT" }, { "label":"Delaware", "value":"DE" }, { "label":"District Of Columbia", "value":"DC" }, { "label":"Federated States Of Micronesia", "value":"FM" }, { "label":"Florida", "value":"FL" }, { "label":"Georgia", "value":"GA" }, { "label":"Guam", "value":"GU" }, { "label":"Hawaii", "value":"HI" }, { "label":"Idaho", "value":"ID" }, { "label":"Illinois", "value":"IL" }, { "label":"Indiana", "value":"IN" }, { "label":"Iowa", "value":"IA" }, { "label":"Kansas", "value":"KS" }, { "label":"Kentucky", "value":"KY" }, { "label":"Louisiana", "value":"LA" }, { "label":"Maine", "value":"ME" }, { "label":"Marshall Islands", "value":"MH" }, { "label":"Maryland", "value":"MD" }, { "label":"Massachusetts", "value":"MA" }, { "label":"Michigan", "value":"MI" }, { "label":"Minnesota", "value":"MN" }, { "label":"Mississippi", "value":"MS" }, { "label":"Missouri", "value":"MO" }, { "label":"Montana", "value":"MT" }, { "label":"Nebraska", "value":"NE" }, { "label":"Nevada", "value":"NV" }, { "label":"New Hampshire", "value":"NH" }, { "label":"New Jersey", "value":"NJ" }, { "label":"New Mexico", "value":"NM" }, { "label":"New York", "value":"NY" }, { "label":"North Carolina", "value":"NC" }, { "label":"North Dakota", "value":"ND" }, { "label":"Northern Mariana Islands", "value":"MP" }, { "label":"Ohio", "value":"OH" }, { "label":"Oklahoma", "value":"OK" }, { "label":"Oregon", "value":"OR" }, { "label":"Palau", "value":"PW" }, { "label":"Pennsylvania", "value":"PA" }, { "label":"Puerto Rico", "value":"PR" }, { "label":"Rhode Island", "value":"RI" }, { "label":"South Carolina", "value":"SC" }, { "label":"South Dakota", "value":"SD" }, { "label":"Tennessee", "value":"TN" }, { "label":"Texas", "value":"TX" }, { "label":"Utah", "value":"UT" }, { "label":"Vermont", "value":"VT" }, { "label":"Virgin Islands", "value":"VI" }, { "label":"Virginia", "value":"VA" }, { "label":"Washington", "value":"WA" }, { "label":"West Virginia", "value":"WV" }, { "label":"Wisconsin", "value":"WI" }, { "label":"Wyoming", "value":"WY" }

 <!-- _v_ -->

![Screenshot](resources/img/6.png)

## More useful examples

#### Time range picker

    {% set startTime = '09:00' %}
    {% set endTime = '17:00' %}
    {% set defaultTime = '13:00' %}
    {% set increments = 15 %}
    {% for time in range(
    	startTime|date('U'),
    	endTime|date('U'),
    	increments * 60
    	) %}
        {{ loop.index > 1 ? ',' }} {    
            "value":"{{ time|date('H:i') }}",
            "label":"{{ time|date('H:i') }}",
            "default":{{ time|date('H:i') == defaultTime ? 'true' : 'false' }}
        }
    {% endfor %}

#### Date range picker

    {% set startDate = '2018-05-18' %}
    {% for i in 0..14 %}
        {% set date = startDate|date_modify('+' ~ i ~ ' day') %}
        {{ loop.index > 1 ? ',' }} {
            "value":"{{ date|date('Y-m-d') }}",
            "label":"{{ date|date("l, jS F Y") }}"
        }
    {% endfor %}

#### UK Counties

    { "value":"Aberdeenshire", "label":"Aberdeenshire" }, { "value":"Angus", "label":"Angus" }, { "value":"Antrim", "label":"Antrim" }, { "value":"Argyll", "label":"Argyll" }, { "value":"Armagh", "label":"Armagh" }, { "value":"Ayrshire", "label":"Ayrshire" }, { "value":"Banffshire", "label":"Banffshire" }, { "value":"Bedfordshire", "label":"Bedfordshire" }, { "value":"Bedfordshire", "label":"Berkshire" }, { "value":"Berwickshire", "label":"Berwickshire" }, { "value":"Bristol", "label":"Bristol" }, { "value":"Buckinghamshire", "label":"Buckinghamshire" }, { "value":"Bute", "label":"Bute" }, { "value":"Caithness", "label":"Caithness" }, { "value":"Cambridgeshire", "label":"Cambridgeshire" }, { "value":"Cheshire", "label":"Cheshire" }, { "value":"City of London", "label":"City of London" }, { "value":"Clackmannanshire", "label":"Clackmannanshire" }, { "value":"Clwyd", "label":"Clwyd" }, { "value":"Cornwall", "label":"Cornwall" }, { "value":"Cumbria", "label":"Cumbria" }, { "value":"Derbyshire", "label":"Derbyshire" }, { "value":"Devon", "label":"Devon" }, { "value":"Dorset", "label":"Dorset" }, { "value":"Down", "label":"Down" }, { "value":"Dumfriesshire", "label":"Dumfriesshire" }, { "value":"Dunbartonshire", "label":"Dunbartonshire" }, { "value":"Durham", "label":"Durham" }, { "value":"Dyfed", "label":"Dyfed" }, { "value":"East Lothian", "label":"East Lothian" }, { "value":"East Riding of Yorkshire", "label":"East Riding of Yorkshire" }, { "value":"East Sussex", "label":"East Sussex" }, { "value":"Essex", "label":"Essex" }, { "value":"Fermanagh", "label":"Fermanagh" }, { "value":"Fife", "label":"Fife" }, { "value":"Gloucestershire", "label":"Gloucestershire" }, { "value":"Greater London", "label":"Greater London" }, { "value":"Greater Manchester", "label":"Greater Manchester" }, { "value":"Gwent", "label":"Gwent" }, { "value":"Gwynedd", "label":"Gwynedd" }, { "value":"Hampshire", "label":"Hampshire" }, { "value":"Herefordshire", "label":"Herefordshire" }, { "value":"Hertfordshire", "label":"Hertfordshire" }, { "value":"Inverness-shire", "label":"Inverness-shire" }, { "value":"Isle of Wight", "label":"Isle of Wight" }, { "value":"Kent", "label":"Kent" }, { "value":"Kincardineshire", "label":"Kincardineshire" }, { "value":"Kinross-shire", "label":"Kinross-shire" }, { "value":"Kirkcudbrightshire", "label":"Kirkcudbrightshire" }, { "value":"Lanarkshire", "label":"Lanarkshire" }, { "value":"Lancashire", "label":"Lancashire" }, { "value":"Leicestershire", "label":"Leicestershire" }, { "value":"Lincolnshire", "label":"Lincolnshire" }, { "value":"Londonderry", "label":"Londonderry" }, { "value":"Merseyside", "label":"Merseyside" }, { "value":"Mid Glamorgan", "label":"Mid Glamorgan" }, { "value":"Midlothian", "label":"Midlothian" }, { "value":"Moray", "label":"Moray" }, { "value":"Nairnshire", "label":"Nairnshire" }, { "value":"Norfolk", "label":"Norfolk" }, { "value":"North Yorkshire", "label":"North Yorkshire" }, { "value":"Northamptonshire", "label":"Northamptonshire" }, { "value":"Northumberland", "label":"Northumberland" }, { "value":"Nottinghamshire", "label":"Nottinghamshire" }, { "value":"Orkney", "label":"Orkney" }, { "value":"Oxfordshire", "label":"Oxfordshire" }, { "value":"Peeblesshire", "label":"Peeblesshire" }, { "value":"Perthshire", "label":"Perthshire" }, { "value":"Powys", "label":"Powys" }, { "value":"Renfrewshire", "label":"Renfrewshire" }, { "value":"Ross and Cromarty", "label":"Ross and Cromarty" }, { "value":"Roxburghshire", "label":"Roxburghshire" }, { "value":"Rutland", "label":"Rutland" }, { "value":"Selkirkshire", "label":"Selkirkshire" }, { "value":"Shetland", "label":"Shetland" }, { "value":"Shropshire", "label":"Shropshire" }, { "value":"Somerset", "label":"Somerset" }, { "value":"South Glamorgan", "label":"South Glamorgan" }, { "value":"South Yorkshire", "label":"South Yorkshire" }, { "value":"Staffordshire", "label":"Staffordshire" }, { "value":"Stirlingshire", "label":"Stirlingshire" }, { "value":"Suffolk", "label":"Suffolk" }, { "value":"Surrey", "label":"Surrey" }, { "value":"Sutherland", "label":"Sutherland" }, { "value":"Tyne and Wear", "label":"Tyne and Wear" }, { "value":"Tyrone", "label":"Tyrone" }, { "value":"Warwickshire", "label":"Warwickshire" }, { "value":"West Glamorgan", "label":"West Glamorgan" }, { "value":"West Lothian", "label":"West Lothian" }, { "value":"West Midlands", "label":"West Midlands" }, { "value":"West Sussex", "label":"West Sussex" }, { "value":"West Yorkshire", "label":"West Yorkshire" }, { "value":"Wigtownshire", "label":"Wigtownshire" }, { "value":"Wiltshire", "label":"Wiltshire" }, { "value":"Worcestershire", "label":"Worcestershire" }

## Templating

Dropdown and Radio Button fields return a single value.

    {{ entry.myDropdownField }}
    // Prints something like: jack
    
Checkboxes and Multi-select fields can have multiple values so these are returned as a JSON-encoded string.

    {{ entry.myCheckboxesField }}
    // Prints something like: ["jack","rebel"]
    
You can loop through these values using the [json_decode](https://docs.craftcms.com/v3/dev/filters.html#json-decode) filter.

    {% for value in entry.myCheckboxesField|json_decode %}
        {{ value }}
    {% endfor %}

---

Brought to you by [Lewis Jenkins](https://lj.io)
