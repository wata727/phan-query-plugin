<?php

namespace PhanQueryPlugin\Test;

use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    const FIXTURE_PATH = __DIR__.'/fixtures';

    public function test_node_matching()
    {
        $work_dir = getcwd();
        try {
            chdir(self::FIXTURE_PATH);
            exec(__DIR__."/../vendor/bin/phan cat.php", $output);

            $this->assertContains("cat.php:19 MatchingNode Matching Node Message", $output);
            $this->assertContains("cat.php:19 MatchingInstanceReceiver Matching Instance Receiver Message", $output);
            $this->assertContains("cat.php:21 MatchingInstanceArugument Matching Instance Arugument Message", $output);
        } finally {
            chdir($work_dir);
        }
    }
}
