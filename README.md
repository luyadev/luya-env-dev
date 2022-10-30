<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# LUYA Dev Environment

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-env-dev/v/stable)](https://packagist.org/packages/luyadev/luya-env-dev)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-env-dev/downloads)](https://packagist.org/packages/luyadev/luya-env-dev)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

The LUYA DEV ENV repo helps you developing new extension and modules or making pull requests to the luya core repos.

## Installation

> **Before installing the env dev project, fork the repos you like to work with.**

1. Clone the luya env dev `git clone https://github.com/luyadev/luya-env-dev.git`
2. Rename `configs/env.php.dist` to `configs/env.php` (`mv configs/env.php.dist configs/env.php`
3. Install composer and init repos `composer install` and afterwards `./vendor/bin/luyadev repo/init`
3. Start the env with docker-compose `docker-compose up`
4. You can now ssh (f.e `docker exec -it luya-env-dev_luya_web_1 /bin/bash`) into the web container and execute the commands `./luya migrate`, `./luya import`, `./luya admin/setup`, `./luya health`.
5. Test your setup and visit `localhost:8080` (Maybe you need to create the `public_html/assets` and `runtime` storage and enable permissions fro them)

**We recommend using docker and therefore using `docker-compose up`, because this will also run an unglue server you can compile styles with**

## Working on CMS and Admin

If you need to work on CMS or Admin modules, we recommend the above steps has been done and you are running with `docker-compose up`.

1. Edit the module files in the folder `repos/luya-module-...`
2. Install deps from the module with `composer install` (inside the folder of that module, f.e `repos/luya-module-admin`) (this will install the unglue binary f.e)
2. If you change js or css code run the unglue watch command **in the modules folder**: `./vendor/bin/unglue watch --server=localhost=localhost:3000`

## Update your local luya-env-dev repos

To fetch the upstream for all forked modules from the `repos` folder run:

`./vendor/bin/luyadev repo/update`

Make sure you push each module after update to get your remote fork even with the upstream.

> Its highly recommend to leave the master branch of the modules untouched to ensure that rebasing works properly. **Always create a new branch to work on it.**

## Changes, collaboration and contribution

For all the FORKED repos (not the read only repos) you can now make changes directly in the `repos/` folder. Assuming you want to make a change in the luya-admin-module which you have forked to your account:

1. Go into the luya-module-admin `cd /repos/luya-module-admin`.
2. Create new branch and commit your changes `git branch my-fix` go into branch `git checkout my-fix`.
3. Make your changes and add them `git add .` and commit `git commit -m 'Added something ...'`.
4. Push branch to your fork `git push origin my-fix`.
5. Create pull request from GitHub.

## Run Unit Tests for a Repo

In order to run your tests for the repo please keep in mind that first of all you have to run `composer install` in the **root of the repo** (e.g. `replos/luya-admin-module`) to install all dependencies afterwards run `./vendor/bin/phpunit tests` in the **root of the repo** to run the tests in the tests-folder.

## Develop your own module or extension 

1. Clone your repo into the repos folder with `./vendor/bin/luyadev repo/clone USERNAME/REPO_NAME`.
2. Create a `Module.php` file accordingly to the [LUYA guide specifications](https://luya.io/guide/app-module).
3. Adding your module via psr-4 binding to your `composer.json` at the autoload section from **luya-env-dev** root directory.
4. Run `composer dump-autoload` for luya-env-dev.
5. Include your module in `configs/env.php`.

> If you would like to use the `@bower` alias inside your own module to include dependencies from `vendor/bower` keep in mind that dependecies need to be installed via composer inside your luya-env-dev root directory.

## Managing assets and vendors in modules and extensions

Please keep in mind that all modules and extensions are treated as independent projects, so do not forget to run in the **root directory of the module** `composer install` and probably `npm install` in the `/resources` directories of modules to download all needed dependencies.

## Find more infos

+ [Installation instructions](https://luya.io/guide/install)
+ [API Documentation](https://luya.io/api)
+ [Collaboration Guide](https://luya.io/guide/luya-collaboration)
+ [Issues on GitHub](https://github.com/luyadev/luya/issues)
