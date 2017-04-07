<?php

namespace DayRev\Synthesizer\Tests\Integration;

use DayRev\Synthesizer\Content;
use DayRev\Synthesizer\Provider;

class ProviderTest extends TestCase
{
    public function testGoogleSynthesizesExpectedContent()
    {
        $provider = Provider::instance('google');
        $content = $provider->synthesize($this->getDataFileContents('text-long.txt'));

        $this->assertInstanceOf(Content::class, $content);
        $this->assertEquals(
            explode("\n", $this->getDataFileContents('audio-google.txt')),
            $content
        );
    }

    protected function getSynthesizerExpectedContent(array $audio): Content
    {
        $content = new Content();
        $content->audio = $audio;

        return $content;
    }

    protected function getDataFileContents(string $filename): string
    {
        return file_get_contents(__DIR__ . '/../Data/' . $filename);
    }
}
