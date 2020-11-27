DDC CodeSniffer
=================================

The documentation for PHP\_CodeSniffer is available on the [Github wiki](https://github.com/squizlabs/PHP_CodeSniffer/wiki).

## Use with Composer

* Add the following lines to your `composer.json` file.
    ```json
    "require-dev": {
        "drugscom/ddc_codesniffer": "*",
        "phpcompatibility/php-compatibility": "*",
    },
    "scripts": {
        "post-install-cmd": [
            "vendor/bin/phpcs --config-set installed_paths vendor/drugscom/ddc_codesniffer,vendor/phpcompatibility/php-compatibility"
        ],
        "post-update-cmd" : [
            "vendor/bin/phpcs --config-set installed_paths vendor/drugscom/ddc_codesniffer,vendor/phpcompatibility/php-compatibility"
        ]
    },
    "repositories" : [
      {
        "type": "git",
        "url": "git@github.com:drugscom/DDC_CodeSniffer.git"
      }
    ]
    ```
* Run `composer update --lock` to install both PHP CodeSniffer, the PHPCompatibility coding standard, and the DDC coding standard.
* Verify that the PHPCompatibility standard is registered correctly by running `./vendor/bin/phpcs -i` on the command line. PHPCompatibility should be listed as one of the available standards.
* Now you can use the following command to inspect your code:
    ```bash
    ./vendor/bin/phpcs -p . --standard=DDC
    ```


## Install OS X

Presuming you used homebrew to install your php the main thing is
getting the DDC ruleset installed

```
brew install homebrew/php/php-code-sniffer
git clone git@github.com:drugscom/DDC_CodeSniffer.git
git clone git clone git@github.com:wimg/PHPCompatibility.git
ln -s "${PWD}/DDC_CodeSniffer/DDC" /usr/local/Cellar/php-code-sniffer/<version>/CodeSniffer/Standards/DDC
ln -s "${PWD}/PHPCompatibility/PHPCompatibility" /usr/local/Cellar/php-code-sniffer/<version>/CodeSniffer/Standards/PHPCompatibility
```
