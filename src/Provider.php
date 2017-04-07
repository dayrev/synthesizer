<?php

namespace DayRev\Synthesizer;

/**
 * Adapter class that handles synthesizer provider interactions.
 */
abstract class Provider
{
    /**
     * Base URL for synthesize requests.
     *
     * @var string
     */
    protected $base_url;

    /**
     * Params to include in synthesize requests.
     *
     * @var array
     */
    protected $params = [];

    /**
     * Max text length that can be synthesized.
     *
     * @var int
     */
    protected $max_text_length;

    /**
     * Gets an instance of the given provider.
     *
     * @param string $provider The name of the provider to instantiate.
     * @param array $data Optional provider data.
     *
     * @return Provider|bool
     */
    public static function instance(string $provider, array $data = [])
    {
        $class = __NAMESPACE__ . '\\Provider\\' . ucfirst($provider);
        if (!class_exists($class)) {
            return false;
        }

        return new $class($data);
    }

    /**
     * Initializes the class.
     *
     * @param array $data Key value data to populate object properties.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->loadData($data);
    }

    /**
     * Attempts to map array data to object properties.
     *
     * @param array $data Key value data to populate object properties.
     *
     * @return void
     */
    protected function loadData(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Builds the synthesized audio file URL for the text.
     *
     * @param string $text Text to synthesize.
     *
     * @return string
     */
    abstract protected function buildAudioUrl(string $text): string;

    /**
     * Returns one or more synthesized audio file URLs for the text.
     *
     * @param string $text Text to synthesize.
     *
     * @return array
     */
    public function synthesize(string $text): Content
    {
        if ($this->getMaxTextLength()) {
            $chunks = $this->chunkText($text);
        } else {
            $chunks = [$text];
        }

        $content = new Content();
        foreach ($chunks as $chunk) {
            $content->audio[] = $this->buildAudioUrl($chunk);
        }

        return $content;
    }

    /**
     * Gets the max text length that can be synthesized.
     *
     * @return int
     */
    public function getMaxTextLength(): int
    {
        return $this->max_text_length;
    }

    /**
     * Chunks text into smaller pieces that are shorter than the TTS provider's max text length.
     *
     * @param string $text Text to synthesize.
     *
     * @return array
     */
    protected function chunkText(string $text): array
    {
        $chunks = [];
        $chunk = '';

        $sentences = preg_split('/(?<=[.?!"])\s+(?=[\(a-z])/i', $text);
        foreach ($sentences as $sentence) {
            if (strlen($chunk . ' ' . $sentence) <= $this->getMaxTextLength()) {
                $chunk .= ' ' . $sentence;
            } else {
                $chunks[] = $chunk;
                $chunk = $sentence;
            }
        }

        // Add the last chunk.
        $chunks[] = $chunk;

        return array_filter($chunks);
    }

    /**
     * Cleans text prior to synthesis.
     *
     * @param string $text The text to clean.
     *
     * @return string
     */
    protected function cleanText(string $text): string
    {
        return utf8_encode(trim($text));
    }

    /**
     * Gets the URL to the synthesized audio file.
     *
     * @return string
     */
    protected function getAudioUrl(): string
    {
        return $this->base_url . '?' . http_build_query($this->params);
    }
}
