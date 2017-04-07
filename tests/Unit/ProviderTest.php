<?php

namespace DayRev\Synthesizer\Tests\Unit;

use DayRev\Synthesizer\Provider;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProviderIsGoogle()
    {
        $provider = Provider::instance('google');

        $this->assertInstanceOf('DayRev\Synthesizer\Provider\Google', $provider);
    }

    public function testProviderIsInvalid()
    {
        $provider = Provider::instance('roboto');

        $this->assertFalse($provider);
    }
}

