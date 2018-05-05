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
            chdir(self::FIXTURE_PATH."/workspace1");
            exec(__DIR__."/../vendor/bin/phan cat.php", $output);

            $this->assertContains("cat.php:19 MatchingNode Matching Node Message", $output);
            $this->assertContains("cat.php:19 MatchingInstanceReceiver Matching Instance Receiver Message", $output);
            $this->assertContains("cat.php:19 MatchingInstanceReceiverWithoutRootNamespace Matching Instance Receiver Without Root Namespace Message", $output);
            $this->assertContains("cat.php:21 MatchingInstanceArugument Matching Instance Arugument Message", $output);
            $this->assertContains("cat.php:21 MatchingAnyInstanceArugument Matching Any Instance Arugument Message", $output);
        } finally {
            chdir($work_dir);
        }
    }

    public function test_test_command_in_no_tests()
    {
        $work_dir = getcwd();
        try {
            chdir(self::FIXTURE_PATH."/no_tests");
            exec(__DIR__."/../bin/phan_query_test", $output);

            $this->assertContains("No tests are found", $output);
        } finally {
            chdir($work_dir);
        }
    }

    public function test_test_command_in_all_tests_are_passed()
    {
        $work_dir = getcwd();
        try {
            chdir(self::FIXTURE_PATH."/all_tests_are_passed");
            exec(__DIR__."/../bin/phan_query_test", $output);

            $this->assertContains("All 2 tests are passed!", $output);
        } finally {
            chdir($work_dir);
        }
    }

    public function test_test_command_in_tests_are_failed()
    {
        $work_dir = getcwd();
        try {
            chdir(self::FIXTURE_PATH."/tests_are_failed");
            exec(__DIR__."/../bin/phan_query_test", $output);

            $this->assertContains("Failed to match test in `MatchingNode`", $output);
        } finally {
            chdir($work_dir);
        }
    }
}
