<?php

namespace App\Http\Controllers;



use App\Models\Images;
use App\Traits\AuthTrait;
use App\Traits\FileTrait;
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
    use FileTrait;

    protected function isOwner(Authenticatable $user, Model $model): bool
    {
        return $user->getAuthIdentifier() === $model->user_id;
    }

    protected function changeImage($image, Model $model): void
    {
        if ($image) {
            $this->deleteImages($model);
            $model->images()->create([
                'url' => Storage::put('businesses/'.$model->id, $image)
            ]);
        }
    }

    protected function deleteImages(Model $model): void
    {
        if ($model->images()->exists()) {
            Storage::delete($model->images->url);
            $model->images()->delete();
        }
    }
}
