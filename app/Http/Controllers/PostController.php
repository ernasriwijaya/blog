<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Post;
  
class PostController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {    
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        return view('posts.create');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $valiator = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'required',
        ]);
  
        $post = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);
  
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $post->addMediaFromRequest('image')->toMediaCollection('images');
        }
  
        return redirect()->route('posts.index');
    }

    public function edit(Posts $posts)
    {
        //
        return view('posts.edit',compact('posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Posts $posts)
    {
        //
        

        $posts->update($request->all());
      

        return redirect()->route('posts.index')

                ->with('success','posts edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts)
    {
        //
        $posts->delete();



        return redirect()->route('posts.index')

                ->with('success','Posts deleted successfully');

}
}