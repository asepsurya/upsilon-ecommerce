<?php

namespace App\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver);
    }

    public function resize(string $path, int $width, ?int $height = null): string
    {
        $image = $this->manager->read($path);
        $image->scale(width: $width);

        if ($height) {
            $image->resize($width, $height);
        }

        $outputPath = $this->getResizedPath($path, $width, $height);
        $image->save($outputPath);

        return $outputPath;
    }

    public function toWebP(string $path, int $quality = 80): string
    {
        $image = $this->manager->read($path);
        $outputPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $path);

        $image->toWebp($quality)->save($outputPath);

        return $outputPath;
    }

    protected function getResizedPath(string $path, int $width, ?int $height): string
    {
        $info = pathinfo($path);
        $suffix = "_{$width}";
        if ($height) {
            $suffix .= "x{$height}";
        }

        return "{$info['dirname']}/{$info['filename']}{$suffix}.{$info['extension']}";
    }
}
