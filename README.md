[![Build Status](https://travis-ci.org/daniel-rose/magento2-widget.svg?branch=master)](https://travis-ci.org/daniel-rose/magento2-widget)

# DR_Widget
Extends the core module "Magento_Widget".

## Description
This module allows to add a widget instance on a specified cms page. Further the "Display On"-dropdown can be enhanced.

## Installation

### Via composer
Open the command line and run the following commands
```
cd PATH_TO_MAGENTO_2_ROOT
composer require dr/widget
```

### Via archive
* Download the ZIP-Archive
* Extract files
* Copy the extracted Files to PATH_TO_MAGENTO_2_ROOT/app/code/DR/Widget
* Run the following Commands:
```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## Support
If you have any issues with this extension, open an issue on GitHub (see URL above).

## Contribution
Any contributions are highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests/).

## Developer
Daniel Rose

* Xing: https://www.xing.com/profile/Daniel_Rose16

## Licence
[MIT License](https://opensource.org/licenses/MIT)

## Copyright
(c) 2016 Daniel Rose