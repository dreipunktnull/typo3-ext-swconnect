# TYPO3 extension ShopwareConnect

A Shopware 5 Connector for TYPO3 CMS 8.7

## Templates & Layouts

### General

The extension registers the global fluid namespace `swc`. This means that you
can access all ShopwareConnect ViewHelpers any time, anywhere - e.g. to resolve and display product images.

### TemplatePaths

The `templateRootPaths` TypoScript option is native to TYPO3 and most developers should feel familiar with it.

In essence you can add a new path where templates are trying to be resolved from:

```typo3_typoscript
plugin.tx_swconnect {
    view {
        templateRootPaths.20 = EXT:mytheme/Resources/Private/Templates/Plugins/SwConnect/
        partialRootPaths.20 = EXT:mytheme/Resources/Private/Partials/Plugins/SwConnect/
        layoutRootPaths.20 = EXT:mytheme/Resources/Private/Layouts/Plugins/SwConnect/
    }
}
``` 

### Images

All product images can be rendered with the `f:media`-ViewHelper once resolved through `swc:media.product.image`.
 
An example for rendering a single products image:

```html
<!-- 
    Grab the Image from the product, then convert it with the media.product.image ViewHelper, 
    then give it a local name. 
-->
{product.images.0 -> swc:media.product.image() -> f:variable(name: 'teaserImage')}

<!--
    Render the assigned image like any other medium with all the traits and benefits of media rendering in TYPO3
-->
{f:media(file: teaserImage)}
```

### Custom templates

The extension adapts the dynamic custom layouts approach from [EXT:news](https://github.com/georgringer/news) (kudos to @georgringer). 
As an integrator you have the option to use layouts through the plugins' flexform, or TypoScript.

To define a layout, you can use TSconfig or the global configuration array:

```php
# ext_tables.php
$GLOBALS['TYPO3_CONF_VARS']['EXT']['sw_connect']['templateLayouts'] = [
    // key => label
    25 => 'LLL:yourext/locallang.xlf:someString',
    26 => 'Bar',
    150 => '--div--,Special Option Group',
    151 => 'Layout Label',
];
```

*or*

TSconfig:

```typo3_typoscript
tx_swconnect.templateLayouts {
    25 = LLL:yourext/locallang.xlf:someString
    26 = Bar
    150 = --div--,Special Option Group
    151 = Layout Label
}
```

Usage in the templates:

```xml
<f:if condition="{settings.templateLayout} == 99">
    <f:then>
        <f:render partial="Teaser" arguments="{_all}"/>    
    </f:then>
    <f:else>
        <f:render partial="Default" arguments="{_all}"/>    
    </f:else>
</f:if>
```

## Signals

Signals can be used to enhance the core extension functionality.

| Class | Signal | Info |
|--------------------------------------|-----------------|--------------------------------------------------------------------------------------------------------|
| `DPN\SwConnect\Backend\ToolbarItems` | `collectStatus` | Implement `DPN\SwConnect\Slot\StatusCollectorSlotInterface` to enhance the Backend Status Item reports |

## CLI Tasks

### Product Header Data

In the first, naive implementation, product names for backend forms were dynamically loaded through a cache.

You need to import the article data through the `sw_connect:articles:import` task before any articles appear in the backend forms.

```bash
vendor/bin/typo3 sw_connect:articles:import
```
