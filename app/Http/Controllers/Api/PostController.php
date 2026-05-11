<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use PhpParser\Node\Expr\Cast\Void_;

use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{


    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return new PostResource(true, 'List Data Posts', $posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]
        );

        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $image = $request->file('image');
        $image->storeAs('public/model', $image->hashName());

        $post = Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

return new PostResource (true,'data post berhasil yey', $post);
}

public function show($id)
{$post=Post::find($id);

return new PostResource(true,'data post berhasil ditemukan', $post);
}


public function update(Request $request,$id)
{
    $validator = Validator::make($request->all(),[
    'title'=>'required',
    'content'=>'required',
    ]);

    if ($validator->fails()){
        return response()->json($validator->errors(),422);

    }
    $post = Post::find($id);

    if($request->hasFile('image')){
    $image = $request->file('image');
    $image->storeAs('public/model', $image->hashName());

    Storage::delete('public/model/'.basename ($post->image));

    $post->update([
        'image' => $image->hashName(),
        'title' => $request->title,
        'content' => $request->content,
    ]);
    }
 return new PostResource(true,'data keubah anjauy',$post);
}

public function destroy($id)
    {

        //find post by ID
        $post = Post::find($id);

        //delete image
        Storage::delete('public/posts/'.basename($post->image));

        //delete post
        $post->delete();

        //return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }


}
