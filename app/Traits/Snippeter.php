<?php

namespace App\Traits;

use App\Snippet;
use Illuminate\Http\Request;
use Auth;

trait Snippeter
{
    public function getSnippets()
    {
        $snippets = Snippet::where('user_id', $this->id)->get();
        
        return $snippets;
    }
     public function getAllSnippets()
    {
        $snippets = Snippet::all();
        
        return $snippets;
    }
    public function addSnippet(Request $req)
    {   
        if($req->hasFile('snippetfile')) {
            $image = $req->file('snippetfile');
            $snippetfilename = time() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('/snippetuploads');
            $image->move($destination, $snippetfilename);
            $filedatabse = $destination . '/' . $snippetfilename;
        }

        $snippeter = Snippet::create([
            'snippetdetails' => $data['tags'],
            'snippetags' => $data['email'],
            'snippetfile' => $filedatabase,
            'user_id' => Auth::user()->id
        ]);

        if($Friendship) {
            return response()->json($Friendship, 200);
        }
        return response()->json('Failed', 501);
    }

    public function getAllLikes($snippet_id)
    {
        $snippet = Snippet::where('id', $snippet_id)->first();

        return $snippet->likes;
    }

    public function likeSnippet($snippet_id)
    {
        $snippet = Snippet::where('id', $snippet_id)->first();

        $snippet->likes += 1;
        
        $snippet->save();

        return $snippet->likes;
    }

    public function unlikeSnippet($snippet_id)
    {
        $snippet = Snippet::where('id', $snippet_id)->first();

        $snippet->likes -= 1;
        
        $snippet->save();

        return $snippet->likes;
    }
}