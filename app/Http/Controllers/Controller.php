<?php

namespace App\Http\Controllers;



use App\Models\Images;
use App\Traits\AuthTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AuthTrait;


    protected function isOwner(Authenticatable $user, Model $model): bool
    {
        return $user->getAuthIdentifier() === $model->user_id;
    }

    protected function changeImage($image, Model $model): void
    {
        if ($image) {
            $this->deleteImages($model);
            $model->images()->update([
                'url' => Storage::put('businesses/'.$model->id, $image)
            ]);
        }
    }

    protected function deleteImages(Model $model): void
    {
        if ($model->images()->exists()) {
            $model->images()?->each(function (Images $image){
                Storage::delete($image->url);
                $image->delete();
            });
        }
    }
}
