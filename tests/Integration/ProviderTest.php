<?php

namespace DayRev\Synthesizer\Tests\Integration;

use DayRev\Synthesizer\Content;
use DayRev\Synthesizer\Provider;

class ProviderTest extends TestCase
{
    public function testAmazonSynthesizesExpectedContent()
    {
        $provider = Provider::instance('amazon', [
            'key' => $this->config['amazon_api_key'],
            'secret' => $this->config['amazon_api_secret'],
        ]);
        $content = $provider->synthesize($this->getDataFileContents('text.txt'));

        // Pre-signed URL is always unique. Parse params to test a few of them.
        parse_str(
            parse_url($content->audio[0], PHP_URL_QUERY),
            $params
        );

        $this->assertInstanceOf(Content::class, $content);
        $this->assertContains($this->config['amazon_api_key'], $params['X-Amz-Credential']);
        $this->assertEquals($this->getDataFileContents('text.txt'), $params['Text']);
    }

    public function testGoogleSynthesizesExpectedContent()
    {
        $provider = Provider::instance('google');
        $content = $provider->synthesize($this->getDataFileContents('text.txt'));

        $this->assertInstanceOf(Content::class, $content);
        $this->assertEquals($this->getSynthesizerExpectedContent(
            explode("\n", $this->getDataFileContents('audio-google.txt'))
        ), $content);
    }

    public function testIbmSynthesizesExpectedContent()
    {
        $provider = Provider::instance('ibm', [
            'username' => $this->config['ibm_username'],
            'password' => $this->config['ibm_password'],
        ]);
        $content = $provider->synthesize($this->getDataFileContents('text.txt'));

        // Replace apikey value with placeholder.
        $config = $this->config;
        $content->audio = array_map(function ($url) use ($config) {
            return str_replace(
                [$config['ibm_username'], $config['ibm_password']],
                ['USERNAME', 'PASSWORD'],
                $url
            );
        }, $content->audio);

        $this->assertInstanceOf(Content::class, $content);
        $this->assertEquals($this->getSynthesizerExpectedContent(
            [$this->getDataFileContents('audio-ibm.txt')]
        ), $content);
    }

    public function testIspeechSynthesizesExpectedContent()
    {
        $provider = Provider::instance('ispeech', ['apikey' => $this->config['ispeech_api_key']]);
        $content = $provider->synthesize($this->getDataFileContents('text.txt'));

        // Replace apikey value with placeholder.
        $config = $this->config;
        $content->audio = array_map(function ($url) use ($config) {
            return str_replace($config['ispeech_api_key'], 'APIKEY', $url);
        }, $content->audio);

        $this->assertInstanceOf(Content::class, $content);
        $this->assertEquals($this->getSynthesizerExpectedContent(
            [$this->getDataFileContents('audio-ispeech.txt')]
        ), $content);
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
