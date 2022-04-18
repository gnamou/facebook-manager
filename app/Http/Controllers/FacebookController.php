<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class FacebookController extends Controller
{

    private $api;
    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->token);
            $this->api = $fb;
            return $next($request);
        });
    }
    
    public function login()
    {
        return Socialite::driver('facebook')->scopes([
            "public_profile, pages_show_list", "pages_read_engagement", "pages_manage_posts", "pages_manage_metadata", "user_videos", "user_posts"
        ])->redirect();
    }

    public function publishToPage(Request $request){


        $page_id = $request->page_id;
        $access_token = $request->access_token;

        Validator::make($request->all(), [
            'contenu' => 'required',
        ])->validate();

        try {
            if ($request->hasFile('image')) {
            
                Validator::make($request->all(), [
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ])->validate();
    
                $destinationPath = public_path().'/images/';
                $file = $request['image'];
                //dd($file->getClientOriginalName());
                $fileName = rand(11111, 99999) . '_'.$file->getClientOriginalName();
                //$extension =$file->getClientOriginalExtension();
                
                $file->move($destinationPath, $fileName);
    
                $post = $this->api->post('/' . $page_id . '/photos', array('message' => $request->contenu, 'source' => $this->api->fileToUpload(public_path('images/'.$fileName))), $access_token);
                unlink(public_path('images/'.$fileName));
                $post = $post->getGraphNode()->asArray();
                if ($post) {
                    $msg = 'Publication effectuée';
                    return back()->with('message', $msg);
                }else{
                    $msg='La publication a echouée.';
                    return back()->with('err', $msg);
                }
                
            }
    
            $post = $this->api->post('/'.$page_id . '/feed?message=' , array('message' =>$request->contenu,), $access_token);
            if ($post) {
                $msg = 'Publication effectuée';
                        
                return back()->with('message', $msg);
            }else{
                $msg='La publication a echouée.';
                return back()->with('err', $msg);
            }
        } catch (FacebookResponseException $e) {
            echo $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }
        
    }
}
