<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Models\Release;
use App\Http\Models\ReleaseSongs;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viewAdminDashboard(Request $request){

        return view('admin.dashboard', $this->template_vars);
    }    

    public function viewLogin(Request $request){
        return view('admin.login', $this->template_vars);
    }

    public function viewReleases(Request $request){

        $rows = Release::selectRaw('id, title as name, release_date as date,song_count')
        ->leftJoin(DB::raw('(select count(*) as song_count, release_id from release_songs GROUP BY release_id) as songs'), 
        function($join)
        {
            $join->on('releases.id', '=', 'songs.release_id');
        })
        ->orderBy('release_date','desc')
        ->get();

        $this->addTemplateVariables(compact('rows'));
        return view('admin.releases.list', $this->template_vars);
    }

    public function newRelease(Request $request){

        $colors = ['lime', 'gold', 'burntred','ice','pink','white','aqua'];
        $this->addTemplateVariables(compact('colors'));
        return view('admin.releases.viewrelease', $this->template_vars);
    } 

    public function editRelease(Request $request, $release_id){

        $release = Release::where('id','=',$release_id)->first();

        $colors = ['lime', 'gold', 'burntred','ice','pink','white','aqua'];
        $this->addTemplateVariables(compact('release', 'colors'));
        return view('admin.releases.viewrelease', $this->template_vars);
    } 

    public function saveNewRelease(Request $request){
        Release::insert(
            [
                'title'=>$request->input('title'),
                'subtitle'=>$request->input('subtitle'),
                'description'=>$request->input('description'),
                'release_date'=>$request->input('release_date'),
                'img_link'=>$request->input('img_link'),
                'background_type'=>$request->input('background_type'),
                'back_img_link'=>$request->input('back_img_link'),
                'gallery_img_link'=>$request->input('gallery_img_link'),
                'theme_color'=>$request->input('theme_color'),
                'youtube_link'=>$request->input('youtube_link'),
                'spotify_link'=>$request->input('spotify_link'),
                'youtube_music_link'=>$request->input('youtube_music_link'),
                'amazon_link'=>$request->input('amazon_link'),
                'iheartradio_link'=>$request->input('iheartradio_link'),
                'distrokid_link'=>$request->input('distrokid_link'),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]
        );

        return redirect('/admin/releases');
    } 

    public function saveRelease(Request $request, $id){
            Release::where('id','=',$id)->update(
                [
                    'title'=>$request->input('title'),
                    'subtitle'=>$request->input('subtitle'),
                    'description'=>$request->input('description'),
                    'release_date'=>$request->input('release_date'),
                    'img_link'=>$request->input('img_link'),
                    'background_type'=>$request->input('background_type'),
                    'back_img_link'=>$request->input('back_img_link'),
                    'gallery_img_link'=>$request->input('gallery_img_link'),
                    'theme_color'=>$request->input('theme_color'),
                    'youtube_link'=>$request->input('youtube_link'),
                    'spotify_link'=>$request->input('spotify_link'),
                    'youtube_music_link'=>$request->input('youtube_music_link'),
                    'amazon_link'=>$request->input('amazon_link'),
                    'iheartradio_link'=>$request->input('iheartradio_link'),
                    'distrokid_link'=>$request->input('distrokid_link'),
                    'updated_at'=>now(),
                ]
                );

                return redirect('/admin/releases');
    } 


    public function login(Request $request){

        $username =  $request->input('username');
        $password = $request->input('password');
        $password_hash = crypt($password, $username);
        $remember = false;

        $user = User::where('username','=',$username)
        ->where('password','=',$password_hash)->first();

        try{
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('admin::dashboard');
        } catch(Exception $e){
            return $password_hash; 
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }



// public function username()
// {
//     return 'username';
// }
}

