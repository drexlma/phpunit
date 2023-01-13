--TEST--
The right events are emitted in the right order for a test that is considered risky because it depends on a larger test
--SKIPIF--
<?php declare(strict_types=1);
if (DIRECTORY_SEPARATOR === '\\') {
    print "skip: this test does not work on Windows / GitHub Actions\n";
}
--FILE--
<?php declare(strict_types=1);
$traceFile = tempnam(sys_get_temp_dir(), __FILE__);

$_SERVER['argv'][] = '--do-not-cache-result';
$_SERVER['argv'][] = '--no-configuration';
$_SERVER['argv'][] = '--no-output';
$_SERVER['argv'][] = '--log-events-text';
$_SERVER['argv'][] = $traceFile;
$_SERVER['argv'][] = __DIR__ . '/_files/test-risky-depends-on-larger-test';

require __DIR__ . '/../../bootstrap.php';

(new PHPUnit\TextUI\Application)->run($_SERVER['argv']);

print file_get_contents($traceFile);

unlink($traceFile);
--EXPECTF--
PHPUnit Started (PHPUnit %s using %s)
Test Runner Configured
Test Suite Loaded (2 tests)
Test Runner Started
Test Suite Sorted
Event Facade Sealed
Test Runner Execution Started (2 tests)
Test Suite Started (%s/test-risky-depends-on-larger-test, 2 tests)
Test Suite Started (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\LargeTest, 1 test)
Test Preparation Started (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\LargeTest::testOne)
Test Prepared (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\LargeTest::testOne)
Assertion Succeeded (Constraint: is true, Value: true)
Test Passed (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\LargeTest::testOne)
Test Finished (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\LargeTest::testOne)
Test Suite Finished (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\LargeTest, 1 test)
Test Suite Started (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\SmallTest, 1 test)
Test Considered Risky (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\SmallTest::testOne)
This test depends on a test that is larger than itself
Test Suite Finished (PHPUnit\TestFixture\Event\RiskyBecauseDependencyOnLargerTest\SmallTest, 1 test)
Test Suite Finished (%s/test-risky-depends-on-larger-test, 2 tests)
Test Runner Execution Finished
Test Runner Finished
PHPUnit Finished (Shell Exit Code: 0)
