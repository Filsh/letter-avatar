<?php

namespace filsh\LetterAvatar;

use Intervention\Image\Gd\Font;
use Intervention\Image\Gd\Shapes\CircleShape;
use Intervention\Image\ImageManager;

class LetterAvatar
{

    /**
     * Image Type PNG
     */
    const MIME_TYPE_PNG = 'image/png';

    /**
     * Image Type JPEG
     */
    const MIME_TYPE_JPEG = 'image/jpeg';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $nameInitials;

    /**
     * @var string
     */
    private $shape;

    /**
     * @var int
     */
    private $size;

    /**
     * @var ColorProviderInterface
     */
    private $colorProvider;

    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * LetterAvatar constructor.
     * @param string $name
     * @param string $shape
     * @param int    $size
     */
    public function __construct(string $name, string $shape = 'circle', int $size = 48, ColorProviderInterface $colorProvider = null)
    {
        $this->setName($name);
        $this->setShape($shape);
        $this->setSize($size);
        $this->setColorProvider($colorProvider);
        $this->setImageManager(new ImageManager());
    }

    /**
     * @param string $name
     */
    private function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param ImageManager $imageManager
     */
    private function setImageManager(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * @param string $shape
     */
    private function setShape(string $shape)
    {
        $this->shape = $shape;
    }

    /**
     * @param int $size
     */
    private function setSize(int $size)
    {
        $this->size = $size;
    }

    /**
     * @param ColorProviderInterface $colorProvider
     */
    private function setColorProvider(ColorProviderInterface $colorProvider = null)
    {
        if ($colorProvider === null) {
            $colorProvider = new RandomColorProvider(2);
        }
        $this->colorProvider = $colorProvider;
    }

    /**
     * @return \Intervention\Image\Image
     */
    private function generate(): \Intervention\Image\Image
    {
        $isCircle = $this->shape === 'circle';

        $this->nameInitials = $this->getInitials($this->name);
        $color = $this->colorProvider->getBackgroundColor($this->name);

        $canvas = $this->imageManager->canvas(480, 480, $isCircle ? null : $color);

        if ($isCircle) {
            $canvas->circle(480, 240, 240, function (CircleShape $draw) use ($color) {
                $draw->background($color);
            });
        }

        $canvas->text($this->nameInitials, 240, 240, function (Font $font) {
            $font->file(__DIR__ . '/fonts/arial-bold.ttf');
            $font->size(220);
            $font->color($this->colorProvider->getTextColor($this->name));
            $font->valign('middle');
            $font->align('center');
        });

        return $canvas->resize($this->size, $this->size);
    }

    /**
     * @param string $name
     * @return string
     */
    private function getInitials(string $name): string
    {
        $nameParts = $this->breakName($name);

        if (!$nameParts) {
            return '';
        }

        $secondLetter = $nameParts[1] ? $this->getFirstLetter($nameParts[1]) : '';

        return $this->getFirstLetter($nameParts[0]) . $secondLetter;
    }

    /**
     * @param string $word
     * @return string
     */
    private function getFirstLetter(string $word): string
    {
        return mb_strtoupper(trim(mb_substr($word, 0, 1, 'UTF-8')));
    }

    /**
     * Save the generated Letter-Avatar as a file
     *
     * @param        $path
     * @param string $mimetype
     * @param int    $quality
     * @return bool
     */
    public function saveAs($path, $mimetype = 'image/png', $quality = 90): bool
    {
        $allowedMimeTypes = [
            'image/png',
            'image/jpeg'
        ];

        if (empty($path) || empty($mimetype) || !\in_array($mimetype, $allowedMimeTypes, true)) {
            return false;
        }

        return \is_int(@file_put_contents($path, $this->generate()->encode($mimetype, $quality)));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->generate()->encode('data-url');
    }

    /**
     * Explodes Name into an array.
     * The function will check if a part is , or blank
     *
     * @param string $name Name to be broken up
     * @return array Name broken up to an array
     */
    private function breakName(string $name): array
    {
        $words = \explode(' ', $name);
        $words = array_filter($words, function($word) {
            return $word !== '' && $word !== ',';
        });
        return array_values($words);
    }

}
