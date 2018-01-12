<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# LUYA Dev Environment

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-env-dev/v/stable)](https://packagist.org/packages/luyadev/luya-env-dev)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-env-dev/downloads)](https://packagist.org/packages/luyadev/luya-env-dev)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

The luya-dev-env repo helps you developing new extension and modules or making pull requests to the luya core repos.

# Installation

> **Before installing the env dev project, fork the repos you like to work with.**

1. Create project into your workspace `composer create-project luyadev/luya-env-dev:^1.0@dev`
  a. When asked `Do you want to remove the existing VCS (.git, .svn..) history?` - answer with `Y`, `Yes`.
2. Run init command `./vendor/bin/luyadev repo/init`
2. Rename `env.php.dist` to `env.php` and modify your *Database connection component* to match your local env settings.
3. Execute commands `./luya migrate`, `./luya import`, `./luya admin/setup`, `./luya health`.
4. Access `public_html` on your webserver.

# Changes, collaboration and contribution

For all the FORKED repos (not the read only repos) you can now make changes directly in the `repos/` folder. Assuming you want to make a change in the luya-admin-module which you have forked to your account:

1. Go into the luya-module-admin `cd /repos/luya-module-admin`.
2. Create new branch and commit your changes `git branch my-fix` go into branch `git checkout my-fix`.
3. Make your changes and add them `git add .` and commit `git commit -m 'Added something ...'`.
4. Push branch to your fork `git push origin my-fix`.
5. Create pull request from GitHub.

# Develop your own module or extension 

1. Clone your repo into the repos folder with `./vendor/bin/luyadev repo/clone USERNAME/REPO_NAME`.
2. Create a `Module.php` file accordingly to the [LUYA guide specifications](https://luya.io/guide/app-module).
3. Adding your module via psr-4 binding to your `composer.json` at the autoload section from **luya-env-dev** root directory.
4. Run `composer dump-autoload` for luya-env-dev.
5. Include your module in `configs/env.php`.

> If you would like to use the `@bower` alias inside your own module to include dependencies from `vendor/bower` keep in mind that dependecies need to be installed via composer inside your luya-env-dev root directory.


# Managing assets and vendors in modules and extensions

Please keep in mind that all modules and extensions are treated as independent projects, so do not forget to run in the **root directory of the module** `composer install` and probably `npm install` in the `/resources` directories of modules to download all needed dependencies.


# Update your local luya-env-dev repos

To fetch the upstream for all forked modules from the `repos` folder run:

`./vendor/bin/luyadev repo/update`

Make sure you push each module after update to get your remote fork even with the upstream.

> Its highly recommend to leave the master branch of the modules untouched to ensure that rebasing works properly. Always create a new branch to work on it.


## Find more infos

+ [Installation instructions](https://luya.io/guide/install)
+ [API Documentation](https://luya.io/api)
+ [Collaboration Guide](https://luya.io/guide/luya-collaboration)
+ [Issues on GitHub](https://github.com/luyadev/luya/issues)
+ [Join the Slack Team](https://slack.luya.io)
+ [Ask us in Gitter](https://gitter.im/luyadev/luya)
