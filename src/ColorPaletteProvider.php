<?php

namespace filsh\LetterAvatar;

class ColorPaletteProvider implements ColorProviderInterface
{

    /**
     * @var array
     */
    private $palette;

    /**
     * @param array $palette
     */
    public function __construct(array $palette)
    {
        $this->palette = $palette;
    }

    /**
     * @inheritdoc
     */
    public function getTextColor(string $string): string
    {
        return '#fafafa';
    }

    /**
     * @inheritdoc
     */
    public function getBackgroundColor(string $string): string
    {
        return $this->palette[array_rand($this->palette)];
    }

}
