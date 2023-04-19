<?php

namespace App\Http\Controllers\Site;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view(Request $request){

        $album_art_heading_type_id = 1;
        $album_art_type_id = 1;
        $visualizer_header_type_id = 5;
        $visualizer_type_id = 2;

        $album_arts = DB::table('portfolio_items')->where('asset_type_id',$album_art_heading_type_id)->first();
        $album_art_images = DB::table('portfolio_assets')->where('type_id',$album_arts->type_id)->whereNull('deleted_at')->limit(8)->get();
        
        $album_art_examples = DB::table('portfolio_items')->where('type_id',$album_art_type_id)->where('asset_type_id', '!=', $album_art_heading_type_id)->get();
        foreach ($album_art_examples as $item){
            $item->images = DB::table('portfolio_assets')->where('type_id',$item->asset_type_id)->get()->toArray();
        }

        $visuazlier_heading_images = DB::table('portfolio_assets')->where('type_id',$visualizer_header_type_id)->whereNull('deleted_at')->limit(8)->get();
    
        $visualizer_examples = DB::table('portfolio_items')->where('type_id',$visualizer_type_id)->where('asset_type_id', '!=', $visualizer_header_type_id)->get();
        foreach ($visualizer_examples as $item){
            $item->images = DB::table('portfolio_assets')->where('type_id',$item->asset_type_id)->get()->toArray();
        }

        $this->addTemplateVariables(compact('album_art_images', 'album_art_examples','visuazlier_heading_images', 'visualizer_examples'));

        return view('portfolio.index', $this->template_vars);
    }
}

