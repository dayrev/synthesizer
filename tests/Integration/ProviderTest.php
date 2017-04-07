<?php

namespace DayRev\Synthesizer\Tests\Integration;

use DayRev\Synthesizer\Content;
use DayRev\Synthesizer\Provider;

class ProviderTest extends TestCase
{
    public function testGoogleSynthesizesExpectedShortContent()
    {
        $provider = Provider::instance('google');
        $content = $provider->synthesize($this->getShortTextToSynthesize());

        $this->assertInstanceOf(Content::class, $content);
        $this->assertEquals($this->getGoogleSynthesizerExpectedShortContent(), $content);
    }

    public function testGoogleSynthesizesExpectedLongContent()
    {
        $provider = Provider::instance('google');
        $content = $provider->synthesize($this->getLongTextToSynthesize());

        $this->assertInstanceOf(Content::class, $content);
        $this->assertEquals($this->getGoogleSynthesizerExpectedLongContent(), $content);
    }

    protected function getGoogleSynthesizerExpectedShortContent(): Content
    {
        return $this->getSynthesizerExpectedContent([
            'https://translate.google.com/translate_tts?tl=en&ie=UTF-8&q=Hello%2C+how+are+you+doing+today%3F&client=dayrev'
        ]);
    }

    protected function getGoogleSynthesizerExpectedLongContent(): Content
    {
        return $this->getSynthesizerExpectedContent([
            'https://translate.google.com/translate_tts?tl=en&ie=UTF-8&q=Heisman+Trophy+finalists+Baker+Mayfield+and+Dede+Westbrook+connected+one+last+time+for+a+touchdown.&client=dayrev',
            'https://translate.google.com/translate_tts?tl=en&ie=UTF-8&q=Joe+Mixon+emerged+with+big+plays+that+had+teammates+lifting+him+off+his+feet+in+celebration.&client=dayrev',
            'https://translate.google.com/translate_tts?tl=en&ie=UTF-8&q=Samaje+Perine+put+his+name+in+Oklahoma%27s+record+books.&client=dayrev',
        ]);
    }

    protected function getSynthesizerExpectedContent(array $audio): Content
    {
        $content = new Content();
        $content->audio = $audio;

        return $content;
    }

    protected function getShortTextToSynthesize(): string
    {
        return file_get_contents(__DIR__ . '/../Data/short-text.txt');
    }

    protected function getLongTextToSynthesize(): string
    {
        return file_get_contents(__DIR__ . '/../Data/long-text.txt');
    }
}
