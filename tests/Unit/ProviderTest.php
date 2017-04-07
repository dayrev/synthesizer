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

    public function testProviderIsIspeech()
    {
        $provider = Provider::instance('ispeech');

        $this->assertInstanceOf('DayRev\Synthesizer\Provider\Ispeech', $provider);
    }

    public function testProviderIsInvalid()
    {
        $provider = Provider::instance('roboto');

        $this->assertFalse($provider);
    }

    public function testProviderMetaDataIsSet()
    {
        $provider = Provider::instance('ispeech', ['apikey' => 'SDGJ8924TFDSF713J']);

        $this->assertObjectHasAttribute('params', $provider);
        $this->assertEquals('SDGJ8924TFDSF713J', $this->getObjectAttribute($provider, 'params')['apikey']);
    }
}
