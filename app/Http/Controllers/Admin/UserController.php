<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\User\UserInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class UserController extends Controller
{
    //
    private $userRepository;

    public function __construct(UserInterface $repo)
    {
        $this->userRepository=$repo;
    }
    public function index(Request $request){
        $users=$this->userRepository->list($request);
        (new ResponsePaginatedApiData($users, $request));
    }
    public function getUser(Request $request){
        $users=$this->userRepository->list($request);
        responseData('data', $users, 200);
    }

    public function show(User $user){
        $user = $this->userRepository->getDetails($user);
        responseData('data', $user, 200);
    }

    public function changeUserIsArchive(Request $request){
        $model= User::find($request->id);
        if ($model) {
            $model->is_archive = $request->is_archive;
            $model->save();
            responseStatus('Archive update successfully', 200);
        }
        responseStatus("Archive can't update for this user,Pls try again", 200);
    }
}
