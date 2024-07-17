<?php

namespace App\Services;

use App\Repositories\ClubRepository;
use Intervention\Image\ImageManager;

class ClubService
{
    /**
     * The club repository instance.
     *
     * @var ClubRepository
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
     * @param ClubRepository $repository
     */
    public function __construct(ClubRepository $repository, ImageManager $images)
    {
        $this->repository = $repository;
        $this->images = $images;
    }

    public function create($club)
    {
        return $this->repository->create($club);
    }

    public function update($club, $data)
    {
        return $this->repository->update($club, $data);
    }

    public function crestUpload($club, $image, $cropCollection)
    {
        $currentImage = $image->getClientOriginalName();
        $cropData = $cropCollection->where('file', '0:/'.$currentImage)->first();
        $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$image->hashName();

        if (isset($cropData->editor) && isset($cropData->editor->crop)) {
            $cropInput = [
                'left' => (int) $cropData->editor->crop->left,
                'top' => (int) $cropData->editor->crop->top,
                'width' => (int) $cropData->editor->crop->width,
                'height' => (int) $cropData->editor->crop->height,
            ];

            $image = $this->images->make($image)
                    ->crop($cropInput['width'], $cropInput['height'], $cropInput['left'], $cropInput['top'])
                    ->resize(250, 250);
        } else {
            $image = $this->images->make($image->path())->fit(250, 250);
        }

        $destination = storage_path().'/temp_images/';
        $localpath = $destination.$filename;
        $image->save($localpath);

        $club->addMedia($localpath)->toMediaCollection('crest');

        return $club;
    }

    public function crestDestroy($club)
    {
        return $this->repository->crestDestroy($club);
    }

    public function getPremierClubs()
    {
        return $this->repository->getClubs(['is_premier'=>true])->pluck('short_code', 'id');
    }

    public function getPremierClubsShortCode()
    {
        return $this->repository->getClubsOrderByShortCode(['is_premier'=>true])->pluck('name', 'id');
    }

    public function getClubNames()
    {
        return $this->repository->getClubs()->pluck('name', 'id');
    }

    public function getPremierClubNames()
    {
        return $this->repository->getClubs(['is_premier'=>true])->pluck('name', 'id');
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function getClubs($where = [])
    {
        return $this->repository->getClubs($where);
    }
}
