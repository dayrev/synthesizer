<?php

namespace DayRev\Synthesizer\Provider;

use DayRev\Synthesizer\Provider;

/**
 * IBM Watson text to speech driver.
 *
 * @see https://www.ibm.com/smarterplanet/us/en/ibmwatson/developercloud/doc/text-to-speech/
 */
class Ibm extends Provider
{
    /**
     * Base URL for synthesize requests.
     *
     * @var string
     */
    protected $base_url = 'https://USERNAME:PASSWORD@stream.watsonplatform.net/text-to-speech/api/v1/synthesize';

    /**
     * Max text length that can be synthesized.
     *
     * @var int
     */
    protected $max_text_length = 5000;

    /**
     * Builds the synthesized audio file URL for the text.
     *
     * @param string $text Text to synthesize.
     *
     * @return string
     */
    public function buildAudioUrl(string $text): string
    {
        // Replace api credential placeholders.
        $this->base_url = str_replace('USERNAME', $this->params['username'], $this->base_url);
        $this->base_url = str_replace('PASSWORD', $this->params['password'], $this->base_url);

        unset($this->params['username']);
        unset($this->params['password']);

        $this->params = array_merge($this->params, array(
            'text' => $this->cleanText($text),
        ));

        return $this->getAudioUrl();
    }
}
