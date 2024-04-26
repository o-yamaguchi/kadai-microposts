<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        // ユーザー一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);
        
        // ユーザー一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users
        ]);
    }
    
    public function show($id)
    {
        // idの値でユーザーを検索して取得
        $user = User::findOrFail($id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        // ユーザーの投稿一覧を作成日時の降順で取得
        // $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        $all_count = $user->allMicropostsCount();

        // ユーザー詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
            'all_count' => $all_count,
            'microposts' => $microposts,
        ]);
    }
    
    /**
     * ユーザーのフォロー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザーのid
     * @return \Illuminate\Http\Response
     */
    public function followings($id)
    {
        // idの値でユーザーを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザーのフォロー一覧を取得
        $followings = $user->followings()->paginate(10);
        $all_count = $user->allMicropostsCount();

        // フォロー一覧ビューでそれらを表示
        return view('users.followings', [
            'user' => $user,
            'all_count' => $all_count,
            'users' => $followings,
        ]);
    }
    

    /**
     * ユーザーのフォロワー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザーのid
     * @return \Illuminate\Http\Response
     */
    public function followers($id)
    {
        // idの値でユーザーを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザーのフォロワー一覧を取得
        $followers = $user->followers()->paginate(10);
        $all_count = $user->allMicropostsCount();

        // フォロワー一覧ビューでそれらを表示
        return view('users.followers', [
            'user' => $user,
            'all_count' => $all_count,
            'users' => $followers,
        ]);
    }
    
    
    public function favorites($id)
    {
        $user = User::findOrFail($id);
        $favorites = $user->favorites()->paginate(10);
        
         // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        $all_count = $user->allMicropostsCount();
    
        return view('users.favorites', [
            'user' => $user,
            'all_count' => $all_count,
            'microposts' => $favorites,
        ]);
    }
}