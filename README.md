# Dev Environment

> **before installing the env dev project, fork the repos you like to work with.**

## Installation

1. Create project into your workspace `composer create-project luyadev/luya-env-dev:^1.0@dev`
  a. When asked `Do you want to remove the existing VCS (.git, .svn..) history?` - answer with `Y`, `Yes`.
2. Run init command `./envdev env/init`
2. Rename `env.php.dist` to `env.php` and modify your *Database connection component* to match your local env settings.
3. Execute commands `./luya migrate`, `./luya import`, `./luya admin/setup`.
4. Access `public_html` on your webserver.

## Changes

For all the FORKED repos (not the read only repos) you can now make changes directly in the `repos/` folder. Assuming you want to make a change in the luya-admin-module which you have forked to your account:

1. Go into the luya-module-admin `cd /repos/luya-module-admin`.
2. Create new branch and commit your changes `git branch my-fix` go into branch `git checkout my-fix`.
3. Make your changes and add them `git add .` and commit `git commit -m 'Added something ...'`.
4. Push branch to your fork `git push origin my-fix`.
5. Create pull request from GitHub.

## Develop your own module or extensions (docs in progress)

1. Go into the repo directory in your initializated luya-env-dev `cd /repos`.
2. Git clone or git init your module or extension here.
3. Create a `Module.php` file accordingly to the LUYA specifications.
4. Adding your module via psr-4 binding to your `composer.json` at the autoload section from luya-env-dev.
5. Run `composer dump-autoload` for luya-env-dev.
6. Include your module in `configs/env.php`.

## Find more infos

+ [Installation instructions](https://luya.io/guide/install)
+ [API Documentation](https://luya.io/api)
+ [Collaboration Guide](https://luya.io/guide/luya-collaboration)
+ [Questions & Issues](https://github.com/zephir/luya/issues)
