# typo3-ext-swconnect

WIP: Shopware 5 Connector for TYPO3 CMS 8.7

## Templates & Layouts

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

## Signals

Signals can be used to enhance the core extension functionality.

| Class | Signal | Info |
|--------------------------------------|-----------------|--------------------------------------------------------------------------------------------------------|
| `DPN\SwConnect\Backend\ToolbarItems` | `collectStatus` | Implement `DPN\SwConnect\Slot\StatusCollectorSlotInterface` to enhance the Backend Status Item reports |
