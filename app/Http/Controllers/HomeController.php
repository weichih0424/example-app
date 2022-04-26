<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Image;
use App\Models\SubMenu;
use App\Models\Ad;
use App\Models\Mvim;
use App\Models\news;
use Illuminate\Support\Facades\Auth;
// use App\models\Total;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->sideBar();

        $mvims=Mvim::where("sh", 1)->get();
        $news=News::where("sh", 1)->get()->filter(function($val, $idx){
            if($idx>4){
                $this->view['more']='/news';
            }else{
                return $val;
            }
        });

        $this->view['mvims']=$mvims;
        $this->view['news']=$news;
        return view('main', $this->view);
    }
    
    protected function sideBar(){
        $menus=Menu::where('sh', 1)->get();
        $images=Image::where('sh', 1)->get();
        $ads=implode("  ", Ad::where("sh", 1)->get()->pluck('text')->all());
        
        foreach($menus as $key => $menu){
            // $subs=SubMenu::where('menu_id', $menu->id)->get();
            $subs=$menu->subs;
            $menu->subs=$subs;
            $menus[$key]=$menu;
        }       
        //若有回傳資料，代表使用者已登入
        if(Auth::user()){
            $this->view['user']=Auth::user();
        }

        // if(!session()->has('visiter')){
        //     $total=Total::first();
        //     $total->total++;
        //     $total->save();
        //     $this->view['total']=$total->total;
        //     // session(['visiter'=>$total->total]);
        //     session()->put('visiter', $total->total);
        // }

        $this->view['ads']=$ads;
        $this->view['menus']=$menus;
        $this->view['images']=$images;
    }

    public function testApi(){
        $data = [
            'test1' => '123',
            'test2' => '456'
        ];
        return $data;
    }
}