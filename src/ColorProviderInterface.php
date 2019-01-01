<?php

namespace filsh\LetterAvatar;

interface ColorProviderInterface
{

    /**
     * @param string $string
     * @return string
     */
    public function getTextColor(string $string): string;

    /**
     * @param string $string
     * @return string
     */
    public function getBackgroundColor(string $string): string;

}
