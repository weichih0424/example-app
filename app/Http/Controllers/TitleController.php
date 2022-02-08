<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Title;

class TitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd($this->view);
        $all=Title::all();
        $cols=['網站標題', '替代文字', '顯示', '刪除', '操作'];
        $rows=[];

        foreach($all as $a){
            $tmp=[
                [
                    'tag'=>'img',
                    'src'=>$a->img,
                    'style'=>'width:300px;header:30px'
                ],
                [
                    'tag'=>'',
                    'text'=>$a->text
                ],
                [
                    'tag'=>'button',
                    'type'=>'button',
                    'btn_color'=>'btn-success',
                    'action'=>'show',
                    'id'=>$a->id,
                    'text'=>($a->sh==1)?'顯示':'隱藏',
                ],
                [
                    'tag'=>'button',
                    'type'=>'button',
                    'btn_color'=>'btn-danger',
                    'action'=>'delete',
                    'id'=>$a->id,
                    'text'=>'刪除',
                ],
                [
                    'tag'=>'button',
                    'type'=>'button',
                    'btn_color'=>'btn-info',
                    'action'=>'edit',
                    'id'=>$a->id,
                    'text'=>'編輯',
                ]
            ];

            $rows[]=$tmp;
        }
        
        // dd($rows);

        // $useTitle=Title::where("sh", 1)->first();
        // $view=[
        //     'header'=>'網站標題管理', 
        //     'module'=>'Title', 
        //     'cols'=>$cols,
        //     'rows'=>$rows,
        //     // 'useTitle'=>$useTitle,
        //     'useTitle'=>$this->useTitle,
        // ];
        $this->view['header']='網站標題管理';
        $this->view['module']='Title';
        $this->view['cols']=$cols;
        $this->view['rows']=$rows;

        // dd($this->view);

        // return view('backend.module', $view);
        return view('backend.module', $this->view);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $view=[
            'action'=>'/admin/title',
            'modal_header'=>'新增網站標題',
            'modal_body'=>[
                [
                    'label'=>'標題區圖片',
                    'tag'=>'input',
                    'type'=>'file',
                    'name'=>'img'
                ],
                [
                    'label'=>'標題區替代文字',
                    'tag'=>'input',
                    'type'=>'text',
                    'name'=>'text'
                ],
            ],
        ];
        return view("modals.base_modal", $view);
        // return view('modals.base_modal', ['modal_header'=>'新增網站標題']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($request->hasFile('img') && $request->file('img')->isValid()){  //hasFile如果有檔案，且isValid被驗證過
            // $filename=$request->file('img')->getClientOriginalName(); //拿到上傳的檔名
            // $request->file('img')->storeAs('img', $filename); //存入img檔案底下，檔名$filename
            // $text=$request->input('text');

            // $title=new Title;
            // $title->img=$filename;
            // $title->text=$text;
            $title=new Title;
            $request->file('img')->storeAs('public', $request->file('img')->getClientOriginalName());

            $title->img=$request->file('img')->getClientOriginalName();
            $title->text=$request->input('text');
            $title->save();
        }
        // return "儲存新資料";
        return redirect(('/admin/title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $title=Title::find($id);
        $view=[
            'action'=>'/admin/title/'.$id,
            'method'=>'patch', //瀏覽器沒有patch的方法，所以需要自行新增
            'modal_header'=>'編輯網站標題資料',
            'modal_body'=>[
                [
                    'label'=>'目前標題區圖片',
                    'tag'=>'img',
                    'src'=>$title->img,
                    'style'=>'width:300px;height:30px'
                ],
                [
                    'label'=>'更換標題區圖片',
                    'tag'=>'input',
                    'type'=>'file',
                    'name'=>'img'
                ],
                [
                    'label'=>'標題區替代文字',
                    'tag'=>'input',
                    'type'=>'text',
                    'name'=>'text',
                    'value'=>$title->text
                ],
            ],
        ];
        return view("modals.base_modal", $view);
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
        $title=Title::find($id);
        if($request->hasFile('img') && $request->file('img')->isValid()){  //hasFile如果有檔案，且isValid被驗證過
            $request->file('img')->storeAs('public', $request->file('img')->getClientOriginalName());
            $title->img=$request->file('img')->getClientOriginalName();
        }
        
        if($title->text!=$request->input('text')){
            $title->text=$request->input('text');
        }

        $title->save();
        
        // return "更新資料";
        return redirect('/admin/title');
    }
    /**
     * 改變資料顯示方法
     */
    public function display($id)
    {
        $title=Title::find($id);

        if($title->sh==1){
            $title->sh=0;

            $findDefault=Title::where("sh", 0)->first();
            $findDefault->sh=1;
            $findDefault->save();
            $img=$findDefault->img;             //改變
        }else{
            $title->sh=1;

            $findShow=Title::where("sh", 1)->first();
            $findShow->sh=0;
            $findShow->save();
            $img=$title->img;                   //不變
        }

        $title->save();
        return $img;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Title::destroy($id);
    }
}
