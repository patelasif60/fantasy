<?php

namespace App\Traits\Fileuploader;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasImageCrop
{
    /**
     * Determine if the request has file that needs to be
     * cropped. This function assumes that the cropping
     * functionality is handled by the following
     * file uploader plugin at
     * https://innostudio.de/fileuploader/.
     *
     * @param string $image
     * @return bool|mixed
     */
    public function imageShouldBeCropped(string $image)
    {
        $allCropData = $this->getImageDetail($image);

        if (! $allCropData) {
            return false;
        }

        $currentImageCropData = $allCropData->first(function ($item) use ($image) {
            return Str::endsWith($item['file'], request()->file($image)->getClientOriginalName());
        });

        $crop = Arr::get($currentImageCropData, 'editor.crop');
        if (! $crop) {
            return false;
        }

        return $crop;
    }

    public function imageShouldBeRotated(string $image)
    {
        $allCropData = $this->getImageDetail($image);

        if (! $allCropData) {
            return false;
        }

        $currentImageCropData = $allCropData->first(function ($item) use ($image) {
            return Str::endsWith($item['file'], request()->file($image)->getClientOriginalName());
        });

        $rotation = Arr::get($currentImageCropData, 'editor.rotation');
        if (! $rotation) {
            return false;
        }

        return $rotation;
    }

    public function getImageDetail($image)
    {
        $allCropData = $this->input('fileuploader-list-'.$image);
        if (! $allCropData || ! is_json($allCropData)) {
            return false;
        }

        return $allCropData = collect(json_decode($allCropData, true));
    }

    public function imageShouldBeDeleted(string $image)
    {
        return $this->getImageDetail($image) && ! $this->getImageDetail($image)->count();
    }

    public function getCropParameters($crop = null)
    {
        if ($crop) {
            return implode(',', [$crop['width'], $crop['height'], $crop['left'], $crop['top']]);
        }
    }
}
