<?php

namespace luya\envdev\envdevcmd;

use Curl\Curl;
use GitWrapper\GitWrapper;
use yii\console\widgets\Table;
use yii\console\Markdown;
use yii\helpers\Console;

class EnvController extends BaseCommand
{
    public $repos = [
        'luya',
        'luya-module-admin',
        'luya-module-cms',
    ];
    
    public $text = <<<EOT

**CLONE REPOS**

We have detected one or more repos which are not cloned to your account. Therefore you can push any changes to those repos and they are **READ ONLY**.

If you just want to work on a specific repo, make sure at least this repo is forked into your Github account.

You can also skip this command, clone the repos and re run this command again.

**FORK ME**
EOT;
    
    private $_gitWrapper;
    
    /**
     * @return \GitWrapper\GitWrapper
     */
    protected function getGitWrapper()
    {
        if ($this->_gitWrapper === null) {
            $this->_gitWrapper = new GitWrapper();
        }
        
        return $this->_gitWrapper;
    }
    
    private function summaryItem($repo, $isFork, $exists)
    {
        return [$repo, $exists, $isFork];
    }
    
    private function getFilesystemRepoPath($repo)
    {
        return 'repos' . DIRECTORY_SEPARATOR . $repo;
    }

    private function forkExists($username, $repo)
    {
        return (new Curl())->get('https://api.github.com/repos/'.$username.'/'.$repo)->isSuccess(); 
    }
    
    private function markdown($text, $paragraph = false)
    {
        $parser = new Markdown();
        
        if ($paragraph) {
            return $parser->parseParagraph($text);
        }
        
        return $parser->parse($text);
    }
    
    public function actionInit()
    {
        // username
        $username = $this->getConfig('username');
        if (!$username) {
            $username = $this->prompt('Whats your Github username?');
            $this->saveConfig('username', $username);
        }
        
        // clonetype
        $cloneType = $this->getConfig('cloneType');
        if (!$cloneType) {
            $cloneType = $this->select('Are you connected via ssh or https?', ['ssh' => 'ssh', 'http' => 'http']);
            $this->saveConfig('cloneType', $cloneType);
        }
        
        $summary = [];
        $itemWithoutFork = false;
        
        // generate summary overview
        foreach ($this->repos as $repo) {
            $newRepoHome = $this->getFilesystemRepoPath($repo);
            if (file_exists($newRepoHome . DIRECTORY_SEPARATOR . '.git')) {
                $summary[] = $this->summaryItem($repo, false, true);
            } elseif ($this->forkExists($username, $repo)) {
                $summary[] = $this->summaryItem($repo, true, false);
            } else {
                $itemWithoutFork = true;
                $summary[] = $this->summaryItem($repo, false, false);
            }
        }
        
        if ($itemWithoutFork) {
            Console::clearScreen();
            $this->outputInfo($this->markdown($this->text));
            foreach ($summary as $sum) {
                if (!$sum[2] && !$sum[1]) {
                    $this->outputInfo($this->markdown("**{$sum[0]}**: https://github.com/luyadev/{$sum[0]}/fork", true));
                }
            }
            echo (new Table())->setHeaders(['Repo', 'Already initialized', 'Fork exists'])->setRows($summary)->run();
            $this->outputError("Repos without fork detected. Those repos will be initialized as READ ONLY. It means you can not push any changes to them.");
            
            if (!$this->confirm("Continue?")) {
                return $this->outputError('Abort by User.');
            }
        }
        
        // foreach summary and clone
        foreach ($summary as $sum) {
            $repo = $sum[0];
            $hasFork = $sum[2];
            $exists = $sum[1];
            
            // continue already initialized repos.
            if ($exists) {
                continue;
            }
            
            $newRepoHome = $this->getFilesystemRepoPath($repo);
            
            if ($hasFork) {
                $cloneUrl = ($cloneType == 'ssh') ? "git@github.com:{$username}/{$repo}.git" : "https://github.com/{$username}/{$repo}.git";
            } else {
                $cloneUrl = ($cloneType == 'ssh') ? "git@github.com:luyadev/{$repo}.git" : "https://github.com/{$username}/{$repo}.git";
            }
            
            $this->cloneRepo($repo, $cloneUrl, $newRepoHome);
        }
        
        return $this->outputSuccess("init complete.");
    }
    
    private function cloneRepo($repo, $cloneUrl, $newRepoHome)
    {
        $this->outputSuccess("{$repo}: cloning ...");
        $this->getGitWrapper()->cloneRepository($cloneUrl, $newRepoHome);
        $this->getGitWrapper()->git('remote add upstream https://github.com/luyadev/'.$repo.'.git',  $newRepoHome);
        $this->outputSuccess("{$repo}: ✔ complete");
    }
    
    public function actionUpdate()
    {
        $wrapper = new GitWrapper();
        
        foreach ($this->repos as $repo) {
            $wrapper->git('checkout master',  'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: checkout master ✔");
            
            $wrapper->git('fetch upstream',  'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: fetch upstream ✔");
            
            $wrapper->git('rebase upstream/master master',  'repos' . DIRECTORY_SEPARATOR . $repo);
            $this->outputInfo("{$repo}: rebase master ✔");
        }
    }
}