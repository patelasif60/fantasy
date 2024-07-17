<?php

namespace App\Services;

use App\Repositories\PredefinedCrestRepository;
use Intervention\Image\ImageManager;

class PredefinedCrestService
{
    /**
     * The team repository instance.
     *
     * @var PredefinedCrestRepository
     */
    protected $repository;

    /**
     * The image manager instance.
     *
     * @var ImageManager
     */
    protected $images;

    /**
     * Create a new service instance.
     *
     * @param PredefinedCrestRepository $repository
     */
    public function __construct(PredefinedCrestRepository $repository, ImageManager $images)
    {
        $this->repository = $repository;
        $this->images = $images;
    }

    public function create($crest)
    {
        return $this->repository->create($crest);
    }

    public function update($crest, $data)
    {
        return $this->repository->update($crest, $data);
    }

    public function crestDestroy($crest)
    {
        return $this->repository->crestDestroy($crest);
    }

    public function check($data)
    {
        return $this->repository->check($data);
    }
}
