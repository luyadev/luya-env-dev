<?php

namespace luya\envdev\envdevcmd;

use Curl\Curl;
use GitWrapper\GitWrapper;

class EnvController extends BaseCommand
{
    public $repos = [
        'luya',
        'luya-module-admin',
        'luya-module-cms',
    ];
    
    public function actionInit()
    {
        $wrapper = new GitWrapper();
        $username = $this->getConfig('username');
       
        if (!$username) {
            $username = $this->prompt('Whats your username?');
            $this->saveConfig('username', $username);
        }
        
        foreach ($this->repos as $repo) {
            $newRepoHome = 'repos' . DIRECTORY_SEPARATOR . $repo;
            if (file_exists($newRepoHome . DIRECTORY_SEPARATOR . '.git')) {
                $this->outputSuccess("repo: \"{$repo}\" already initalize.");
                continue;
            }
            
            $hasFork = (new Curl())->get('https://github.com/'.$username.'/'.$repo.'.git')->isRedirect(); // will redirect to github page with 301
            
            if (!$hasFork) {
                $this->outputInfo("We could not find a fork {$username}/{$repo}! We can setup a read only instance, you can't change. If you want to work on this module you should clone it first!");
                
                if ($this->confirm("proceed with read only repo for {$repo}.")) {
                    $wrapper->cloneRepository('git://github.com/luyadev/'.$repo.'.git', $newRepoHome);
                    $this->outputSuccess("Repo {$repo} cloned into repos");
                    $cmd = $wrapper->git('remote add upstream https://github.com/luyadev/'.$repo.'.git',  $newRepoHome);
                    $this->outputSuccess("add remote upstream.");
                }
            } else {
                $wrapper->cloneRepository('git://github.com/'.$username.'/'.$repo.'.git', $newRepoHome);
                $this->outputSuccess("Repo {$repo} cloned into repos");
                $cmd = $wrapper->git('remote add upstream https://github.com/luyadev/'.$repo.'.git',  $newRepoHome);
                $this->outputSuccess("add remote upstream.");
            }
        }
        
        return $this->outputSuccess("init complet.");
    }
    
    public function actionUpdate()
    {
        $wrapper = new GitWrapper();
        
        foreach ($this->repos as $repo) {
            $wrapper->git('checkout master',  'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: checkout master ✔");
            
            $wrapper->git('git fetch upstream',  'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: fetch upstream ✔");
            
            $wrapper->git('git rebase upstream/master master',  'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: rebase master ✔");
        }
    }
}