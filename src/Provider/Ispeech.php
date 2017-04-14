<?php

namespace DayRev\Synthesizer\Provider;

use DayRev\Synthesizer\Provider;

/**
 * Driver class that handles iSpeech API interactions.
 *
 * @see http://www.ispeech.org/api/
 */
class Ispeech extends Provider
{
    /**
     * Base URL for synthesize requests.
     *
     * @var string
     */
    protected $base_url = 'http://api.ispeech.org/api/rest';

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
            'action' => 'convert',
            'text' => $this->cleanText($text),
        ));

        return $this->getAudioUrl();
    }
}
