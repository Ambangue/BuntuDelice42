<?php

namespace App\Http\Controllers\admin;

use App\News;
use App\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function notification( $body,$title,$device_token,$key,$click_action)
    {
       
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $tokenList = $device_token;
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => true,
        ];
        $extraNotificationData = ["key" => $key, "click_action" =>$click_action];
        $fcmNotification = [
            'registration_ids' => $tokenList, //multiple token array
            //'to' => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key= AAAAGem_t_Q:APA91bHtrZm7cIzbtlnzrwrS8jcszUwx6kPEQS_ZY9nG359OwmlgZYzNc6elU6LLBVmuigcXL11isK-1oVMgwq-LjGGcqV22ERlsWacsgI4KLc9KwJNUIDPLPmYZ1N4ZabV4sxjkcvQT',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return response()->json(['data' => 'notification sent', 'action' => $result], 200);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $news = News::all();
        return view('admin.news.index')->with('news', $news);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description'=>'required'
        ]);
        $news=News::create($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'News Created Successfully';
        return redirect()->route('news.index')->with('alert', $alert);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(News $news)
    {
        return view('admin.news.edit')->with('news', $news);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description'=>'required'
        ]);
        $news->update($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'News updated Successfully';
        return redirect()->route('news.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(News $news)
    {
        $news->delete();

        $alert['type'] = 'success';
        $alert['message'] = 'News Deleted Successfully';
        return redirect()->route('news.index')->with('alert', $alert);
    }
    
     public function sentNotification($id)
    {
        $getNews=News::find($id);
        $driver=Driver::get();
        $device_token=$driver->pluck('device_token')->toArray();
        
        
        $body=$getNews->description;
        $title=$getNews->title;
        $key='news';
        $click_action='news_activity';
        $data=$this->notification($body,$title,$device_token,$key,$click_action);
        dd($data);
        $alert['type'] = 'success';
        $alert['message'] = 'News Sent Successfully';
        return redirect()->back()->with('alert', $alert);
    }
}
