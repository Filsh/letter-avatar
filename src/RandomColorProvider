<?php

namespace YoHang88\LetterAvatar;

class RandomColorProvider implements ColorProviderInterface
{

    /**
     * @var int
     */
    private $darker;

    /**
     * @param int $darker
     */
    public function __construct(int $darker)
    {
        $this->darker = $darker;
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
        // random color
        $rgb = substr(dechex(crc32($string)), 0, 6);

        list($R16, $G16, $B16) = str_split($rgb, 2);
        $R = sprintf('%02X', floor(hexdec($R16) / $this->darker));
        $G = sprintf('%02X', floor(hexdec($G16) / $this->darker));
        $B = sprintf('%02X', floor(hexdec($B16) / $this->darker));
        return '#' . $R . $G . $B;
    }

}
