<?php

namespace DayRev\Synthesizer\Provider;

use DayRev\Synthesizer\Provider;

/**
 * Driver class that handles Google interactions.
 */
class Google extends Provider
{
    /**
     * Base URL for synthesize requests.
     *
     * @var string
     */
    protected $base_url = 'https://translate.google.com/translate_tts';

    /**
     * Max text length that can be synthesized.
     *
     * @var int
     */
    protected $max_text_length = 100;

    /**
     * Builds the synthesized audio file URL for the text.
     *
     * @param string $text Text to synthesize.
     *
     * @return string
     */
    public function buildAudioUrl(string $text): string
    {
        $this->params = array_merge($this->params, [
            'tl'     => 'en',
            'ie'     => 'UTF-8',
            'q'      => $this->cleanText($text),
            'client' => 'dayrev',
        ]);

        return $this->getAudioUrl();
    }
}
