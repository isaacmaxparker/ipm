<?php

namespace App\Http\Controllers\Site;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Http\Request;

class MusicController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viewAll(Request $request){

        $latest = DB::table('releases')->orderBy('release_date','desc')->first();
        $this->addTemplateVariables(compact('latest'));

        return view('music.catalog', $this->template_vars);
    }

    public function viewRelease(Request $request, $id){
        $release = DB::table('releases')->where('id','=',$id)->first();
        $other_releases = DB::table('releases')->where('id','!=',$id)->orderBy('release_date','desc')->get();
        
        $songs = DB::table('songs')->join('release_songs','songs.id','release_songs.song_id')->where('release_id','=',$release->id)->get();
        
        foreach($songs as $song){
            if(str_contains($song->title,'(')){
                $song->title = str_replace('(','<br> (', $song->title);
            }
        }
        
        
        $this->addTemplateVariables(compact('release','songs','other_releases'));

        return view('music.release', $this->template_vars);
    }

}

