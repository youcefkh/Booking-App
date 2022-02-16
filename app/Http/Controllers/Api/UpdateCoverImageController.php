<?php

namespace App\Http\Controllers\Api;

use App\Models\CoverImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UpdateCoverImageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user_id = Auth::user()->id;
        $image = CoverImage::where('user_id', $user_id)->first();

        $OriginalsPath = 'assets/cover/originals';
        $thumbnailsPath = 'assets/cover/thumbnails';

        //dd($request->original->extension());
        if( $request->hasFile( 'original' ) ) {
            $original = $request->original;
            $image_name = $user_id . '-' . time() . '.'.$original->extension();
            //store original
            $original->move(public_path($OriginalsPath),$image_name);
            $image->original = $image_name;
            //store thumbnail
            copy(public_path($OriginalsPath).'/'.$image_name, public_path($thumbnailsPath).'/'.$image_name);
            $image->cropped = $image_name;
        }
        
        if( $request->hasFile( 'cropped' ) ) {
            $cropped = $request->cropped;
            $image_name = $user_id . '-' . time() . '.'.$cropped->extension();
            $cropped->move(public_path($thumbnailsPath),$image_name);
            $image->cropped = $image_name;
            
        }

        $image->save();

        return $image;
    }
}
