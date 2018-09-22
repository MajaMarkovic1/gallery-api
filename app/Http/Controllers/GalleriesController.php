<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\User;
use App\Image;
use App\Comment;

use Illuminate\Http\Request;
use App\Http\Requests\StoreGalleriesRequest;


class GalleriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'showAuthor']]); 
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gallery::with(['images', 'user', 'comments'])->orderBy('created_at', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGalleriesRequest $request)
    {

        $gallery = new Gallery();
        $gallery->title = $request['title'];
        $gallery->description = $request['description'];
        $gallery->user_id = auth()->user()->id;
        $gallery->save();

        $images = [];

        foreach ($request->images as $image) {
           array_push($images, new Image([
               'image_url' => $image
               ]));
        }

        $gallery->images()->saveMany($images);
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Gallery::with(['user', 'images', 'comments.user'])->findOrFail($id);
        
    }

    public function showAuthor($id)
    {
        return User::where('id', $id)->with('galleries.images')->first();
    }

    public function showMyGalleries()
    {
        return User::where('id', auth()->user()->id)->with('galleries.images')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Gallery::destroy($id);
    }
}
