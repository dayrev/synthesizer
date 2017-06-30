<?php

namespace DayRev\Synthesizer\Provider;

use Aws\Polly\PollyClient;
use DayRev\Synthesizer\Provider;

/**
 * Amazon Polly text to speech driver.
 *
 * @see http://docs.aws.amazon.com/polly/latest/dg/what-is.html
 */
class Amazon extends Provider
{
    /**
     * Max text length that can be synthesized.
     *
     * @var int
     */
    protected $max_text_length = 1500;

    /**
     * Builds the synthesized audio file URL for the text.
     *
     * @param string $text Text to synthesize.
     *
     * @return string
     */
    public function buildAudioUrl(string $text): string
    {
        $this->params = array_merge($this->params, array(
            'text' => $this->cleanText($text),
        ));

        return $this->getAudioUrl();
    }

    /**
     * Gets the URL to the synthesized audio file.
     *
     * @return string
     */
    protected function getAudioUrl(): string
    {
        $client = new PollyClient([
            'version' => 'latest',
            'region' => $this->params['region'] ?? 'us-west-2',
            'credentials' => [
                'key' => $this->params['key'],
                'secret' => $this->params['secret'],
            ],
        ]);

        return $client->createSynthesizeSpeechPreSignedUrl([
            'OutputFormat' => $this->params['OutputFormat'] ?? 'mp3',
            'SampleRate' => $this->params['SampleRate'] ?? '22050',
            'Text' => $this->params['text'],
            'TextType' => $this->params['TextType'] ?? 'text',
            'VoiceId' => $this->params['VoiceId'] ?? 'Joanna',
        ]);
    }
}
