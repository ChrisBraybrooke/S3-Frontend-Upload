# Laravel Package Template

An opinionated template for creating my new laravel packages.

## Installation

Replace `package-name` below with the name of the new package, for example `sns-messages`

```
git clone git@github.com:ChrisBraybrooke/Laravel-Package-Template.git package-name
cd package-name
git remote set-url origin new-url.git
git push -u origin master
```

## Setup
1. Do a find and replace on all files within the directory for `PACKAGE_NAME`, `NAMESPACE_HERE` & `CONFIG_NAME` - examples for these values, sticking with the SNS theme would be `sns-messages`, `SnsMessages` and `sns`.

2. You should also rename the `config/config.php` file with the same value of `CONFIG_NAME`.

## Working on Package
Orchestra canvas is installed for convinience, and makes it super simple to create new files as if you were using artisan. Simply run `composer exec canvas` followed by the make command of choice, for example `composer exec canvas make:migration create_posts_table`.

You will need a 'host' project, this could be a blank laravel install or another project.

```
cd host-project
vim composer.json
```

Then paste the following anywhere in the file.

```
"repositories": {
    "chrisbraybrooke/package-name": {
        "type": "path",
        "url": "package-url-on-filesystem",
        "options": {
            "symlink": true
        }
    }
}
```

Finally install the package on the host project

```
composer require chrisbraybrooke/package-name
```
