<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUsersModel;
use App\Services\SignUp_Store_Service;
use Exception;
use PDOException;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(AdminUsersModel::select('id', 'name', 'account', 'password')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SignUp_Store_Service $SignUp_Store_Service)
    {
        $account = $request->account;
        $password = $request->password;
        $username = $request->username;
        try{
            if($SignUp_Store_Service->signUp($account, $password, $username)){
                return response()->json([
                    'success' => 'true'
                ]);
            }
        } catch (PDOException $e){
            return response()->json([
                'success' => 'false',
                'error'=> 'DB error'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => 'false',
                'error'=> $e->getMessage()
            ]);
        }
        // try{
        //     if($SignUp_Store_Service->signUp($account, $password, $username)){
        //         return response()->json([
        //             'success' => 'true'
        //         ]);
        //     }
        // } catch (Exception $e){
        //     return response()->json([
        //         'success' => 'false',
        //         'error'=> $e->getMessage()
        //     ]);
        // }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(AdminUsersModel::select('id', 'name', 'account')->where('id', $id)->first());
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
        $AdminUsersModel = AdminUsersModel::find($id);
        if($AdminUsersModel!==null){
            $AdminUsersModel->update($request->all());
            return response()->json([
                'success' => 'true'
            ]);
        }
        return response()->json([
            'success' => 'false'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $AdminUsersModel = AdminUsersModel::find($id);
        if($AdminUsersModel!==null){
            AdminUsersModel::destroy($id);
            return response()->json([
                'success' => 'true'
            ]);
        }
        return response()->json([
            'success' => 'false'
        ]);
    }
}
