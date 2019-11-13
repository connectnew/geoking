<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\gmb\lib\Google_my_business;
use App\Posts;
use DB;
use DateTimeZone;
use Auth;
use DataTables;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function create()
    {
		$locationsArr = $this->fetchLocations();
		
		$tzlist = \DateTimeZone::listIdentifiers(DateTimeZone::ALL);
		
        return view('createpost')->with(array('tzlist'=> $tzlist, 'locationsArr'=>$locationsArr));
    }
   
    
    public function createGmbPost(Request $request)
    {
		
		$user = Auth::User();     
        $userId = $user->id; 
        
		$access_token = $this->generateGmbAccessToken(); 
		
		$event_title = $request->input('event_title');
		$event_description = $request->input('event_description');
		$img_url = $request->input('img_url');
		$button_name = $request->input('button_name');
		$button_url = $request->input('button_url');
		$add_button = $request->input('add_button');
		$locations = $request->input('location');
		$location_name = $request->input('location_name');
		
		if($add_button == 1){
			$callToAction='"callToAction": {
					"actionType": "'.$button_name.'",
					"url": "'.$button_url.'",
				  },';
		}else{
			$callToAction='';
			
		}
		 $imageName=''; $filename='';  $baseUrl = url('/'); $video_url='';
		if(request()->selectImage){
			
		        request()->validate([

            'selectImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

  

          $imageName = time().'.'.request()->selectImage->getClientOriginalExtension();



         request()->selectImage->move(public_path('images'), $imageName);
        // echo URL::to('/');
         
          $img_url = $baseUrl.'/images/'.$imageName; 
	 }
         
          
			if(request()->selectVideo){
			   $file = request()->selectVideo;
			   $filename =request()->selectVideo->getClientOriginalName();
			   $path = public_path().'/images/';
			   $file->move($path, $filename);
			    $video_url = $baseUrl.'/images/'.$filename; 
			}
   //    }
        

		$s_year = date('Y');
		$s_month = date('n');
		$s_date = date('j');
		
		$s_hour = date('g');
		$s_min = date('i');
$current_date = date('Y-m-d h:i:s');
$end_date = date('Y-m-d h:i:s', strtotime($current_date . ' +7 day'));
$e_year = date('Y', strtotime($current_date . ' +7 day'));
$e_month = date('n', strtotime($current_date . ' +7 day'));
$e_date = date('j', strtotime($current_date . ' +7 day'));
$e_hour = date('g', strtotime($current_date . ' +7 day'));
$e_min = date('i', strtotime($current_date . ' +7 day'));
$e_min =	intval($e_min);	
$s_min =	intval($s_min);	
		$media='';
		if($img_url !=''){
		$media = '"media": [
				{
				  "mediaFormat": "PHOTO",
				  "sourceUrl": "'.$img_url.'"
				}
			  ]';
		  }
		  
		  //~ if($video_url !=''){
		//~ $media = '"media": [
				//~ {
				  //~ "mediaFormat": "VIDEO",
				  //~ "sourceUrl": "'.$video_url.'"
				//~ }
			  //~ ]';
		  //~ }
		$json = '{
			  "languageCode": "en-US",
			  "summary": "'.$event_description.'",
			    '.$callToAction.'
			  "event": {
				"title": "'.$event_title.'",
				"schedule": {
					"startDate": {
						"year": '.$s_year.',
						"month": '.$s_month.',
						"day": '.$s_date.'
					  },
					  "startTime": {
						  "hours": '.$s_hour.',
						  "minutes": '.$s_min.',
						  "seconds": 0,
						  "nanos": 0
					  },
					  "endDate": {
						"year": '.$e_year.',
						"month": '.$e_month.',
						"day": '.$e_date.'
					  },
					  "endTime": {
						    "hours": '.$e_hour.',
						  "minutes": '.$e_min.',
						  "seconds": 0,
						  "nanos": 0
					  },
				}
			  },
			 '.$media.'
			}';

	//echo $json ; die;
	
	try{
		$gmb_post_id_arr = array();
		
		if($request->get('schedule_option') == 1){
			foreach($locations as $location){
		$endpoint = 'https://mybusiness.googleapis.com/v4/'.$location.'/localPosts';	
		$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
		$response = $client->request('POST', $endpoint, ['body' => $json]);

		 $statusCode = $response->getStatusCode(); 
		
		  $content = $response->getBody();// die;
		$contentArr = json_decode($content);
		 $gmb_post_id = $contentArr->name;
		 array_push($gmb_post_id_arr, $gmb_post_id);
			}
		
		}
		 $post = new Posts();
		 $post->title= $request->get('event_title');
		 $post->description= $request->get('event_description');
		 $post->img_url= $request->get('img_url');
		 $post->location= implode(',',$request->get('location'));
		 $post->button= $request->get('add_button');
		 $post->button_name= $request->get('button_name');
		 $post->button_url= $request->get('button_url');
		 $post->video= $filename;
		 $post->image= $imageName;
		 $post->schedule_option= $request->get('schedule_option');
		 $post->start_date= date('Y-m-d');
		 
		  $post->end_date= $end_date;
		 if($request->get('schedule_option') == 2){
			 $post->start_date= $request->get('s_start_date');
			 
				 if($request->get('repeat') == 'no-repeat'){
				 
					$post->remaining_posts= 1;
				 }else{
					 if($post->expire_check != '1'){
						 $post->remaining_posts=100;
					 }else{
					$post->remaining_posts= $request->get('event_expire');
					}
				 }
			 
		 }
		 $post->time= $request->get('s_time');
		 $post->end_date= $request->get('end_date');
		 $post->timezone= $request->get('timezone');
		 $post->repeat_post= $request->get('repeat');
		 $post->expire_check= $request->get('expire_check');
		 $post->repeat_option= $request->get('repeat_option');
		 $post->event_expire= $request->get('event_expire');
		 $post->user_id= $userId;
		  $post->location_name= $location_name;
		 
		 if($request->get('schedule_option') == 1){
			 $post->gmb_post_id= implode(',',$gmb_post_id_arr);
			 $post->status= $contentArr->state;
			 $post->timezone= '';
			  $post->repeat_post= '';
			 $post->expire_check= '';
			 $post->repeat_option= '';
			 $post->event_expire= '';
		 }
		 
		 

		 if($post->title != ''){
			//print_r($post); die;
			 $postObj = $post->save();
			//~ // $postid = $postObj->getKey();
			//~ //print($post->id); 
			//~ $start_date = $request->get('s_start_date');
			//~ $repeat_option = $request->get('repeat_option');
			 //~ $next_date = date('Y-m-d', strtotime( $start_date. '+'.$repeat_option)); 
			//~ DB::table('next_post_date')->insert(['post_id' =>$postid, 'next_date' => $next_date,'post_time'=>$request->get('s_time'), 'post_status'=> 0 ]); 
		 
		}
		
		
	}catch (\Exception $ex) {
			$msg=	$ex->getMessage();
			return redirect('create-post')->with('message', 'Something went wrong. Try again later.'.$msg);
	}
		return redirect('create-post')->with('message', 'You Post has been successfully created.');
    }
    
    public function schedule()
    {
		$tzlist = \DateTimeZone::listIdentifiers(DateTimeZone::ALL);
       $locationsArr = $this->fetchLocations();
		$localPosts = Posts::get(); 
        return view('schedulepost')->with(array('localPosts'=> $localPosts, 'tzlist'=> $tzlist ,'locationsArr'=>$locationsArr));
		
    }
    
    public function schedulepost($id)
    {
		//echo $id;
		
		$res =  DB::table('gmb_events')->where(['id' => $id ])->first();  
		//~ echo "<pre>";
		//~ print_R($res); 
		//~ die;
		$selectedlocations = explode(',',$res->location);
		$tzlist = \DateTimeZone::listIdentifiers(DateTimeZone::ALL);
       $locationsArr = $this->fetchLocations();
		$localPosts = Posts::get(); 
        return view('schedulepost')->with(array('localPosts'=> $localPosts, 'tzlist'=> $tzlist ,'locationsArr'=>$locationsArr,'post_id' =>$id));
		
    }
    
    public function manageposts()
    {	
		//$postViews = $this->fetchPostViews();// die;
		$postCount = $this->postCount(); 
		$locationsArr = $this->fetchLocations(); 
		$localPosts = Posts::get(); 
        return view('manageposts')->with(array('localPosts'=> $localPosts, 'locationsArr'=>$locationsArr , 'postCount' => $postCount));
    }
    
    public function postlibrary()
    {
        return view('postlibrary');
    }
    
    public function analytics()
    {
        return view('postanalytics');
    }
    
    /*
     * Function for deleting Post 
     */
     
    function delete(Request $request){
		
		//deleting from db
		
		$post_id = $request->get('post_id');
		//deleting from GMB
		$postdata = Posts::where('id',  $post_id)->first();
	 $locations=	explode(',',$postdata->gmb_post_id);
		$access_token = $this->generateGmbAccessToken();
		 
		$data = Posts::where('id',  $post_id)->delete();
		try{
			foreach($locations as $location){
			$endpoint = 'https://mybusiness.googleapis.com/v4/'.$location;	
			$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
			$response = $client->request('DELETE', $endpoint, []);
			$content = $response->getBody(); 
			$contentArr =  json_decode($content); //die;
			print_r($contentArr);
			}
			//return redirect('/manage-posts')->with('message', 'You Post has been successfully deleted.');
		}catch (\Exception $ex) {
			$msg=	$ex->getMessage();
			//return redirect('/manage-posts')->with('message', 'You Post has been successfully deleted.');
		}
	}
	 
	/*
	 * 
	 */
	function generateGmbAccessToken(){
		
		$user = Auth::User();     
        $userId = $user->id; 
        
		$GOOGLE_CLIENT_ID =  env("GOOGLE_CLIENT_ID");
        $GOOGLE_SECRET_ID =  env('GOOGLE_CLIENT_SECRET');  
		
		$userData = DB::table('oauth')->where(['user_id' => $userId ])->first();
		$token = json_decode($userData->token);
		$refresh_token = $token->refresh_token; 
		
		//~ $client_id = '1075153362334-vlu4u4ikm4ggcuk73g0rpp0m994p5hg7.apps.googleusercontent.com';
		//~ $client_secret = 'jOTgIXDxHKeP3Ii5Vy3Mwm-h';
		//$refresh_token = '1/Lrza_G49NJmEPtsKUA429faLdOa8zmuAxHVjd5sjMbBE7cNZWzOyi_ZfvCPB_VNl'; 
		//1/zomIw2x1HQ1VOTWLcPOlhKp-D2s1rOvP0BUGav7GodeIUilJUPVmMDKxDCx8bP2F
		$endpoint = 'https://www.googleapis.com/oauth2/v4/token';	
		$client = new \GuzzleHttp\Client();
		$response = $client->request('POST', $endpoint, ['query' => [
				'client_id' => $GOOGLE_CLIENT_ID, 'client_secret' => $GOOGLE_SECRET_ID, 'refresh_token' => $refresh_token,'grant_type'=> 'refresh_token' 
				]]);

		$statusCode = $response->getStatusCode();
		$content = $response->getBody(); 
		$dataArr = json_decode($content);
		$access_token =  $dataArr->access_token; 
		return $access_token;
		
	}
	
	
	function edit($id ,Request $request){
		$tzlist = \DateTimeZone::listIdentifiers(DateTimeZone::ALL);
		$data = Posts::where('id',  $id)->first();
		$locationsArr = $this->fetchLocations();
		
		$selectedLocArr = explode(',',$data->location);
		return view('editpost')->with(array('postdata'=> $data,'tzlist'=>$tzlist , 'locationsArr'=>$locationsArr, 'selectedLocArr' => $selectedLocArr));
		
	
	}
	
	function update(Request $request){
		
		 $access_token = $this->generateGmbAccessToken(); //die;
		 
		$id = $request->input('id');
		$event_title = $request->input('event_title'); 
		$event_description = $request->input('event_description');
		$img_url = $request->input('img_url');
		$button_name = $request->input('button_name');
		$button_url = $request->input('button_url');
		$add_button = $request->input('add_button');
		$callToAction='';
		
		if($add_button == 1){
			$callToAction='"callToAction": {
					"actionType": "'.$button_name.'",
					"url": "'.$button_url.'",
				  },';
		}
		
		$olddata = Posts::where('id',  $id)->first();
		 $gmb_post_id_arr = explode(',',$olddata->gmb_post_id);

		   $imageName=''; $filename='';
		if(request()->selectImage){
			
		        request()->validate([

            'selectImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

  

         $imageName = time().'.'.request()->selectImage->getClientOriginalExtension();



         request()->selectImage->move(public_path('images'), $imageName);
	 }
         
          
			if(request()->selectVideo){
			   $file = request()->selectVideo;
			   $filename =request()->selectVideo->getClientOriginalName();
			   $path = public_path().'/images/';
			   $file->move($path, $filename);
			}
		$s_year = date('Y');
		$s_month = date('n');
		$s_date = date('j');
		
		$s_hour = date('g');
		$s_min = date('i');
$current_date = date('Y-m-d h:i:s');
echo $e_year = date('Y', strtotime($current_date . ' +7 day'));
$e_month = date('n', strtotime($current_date . ' +7 day'));
$e_date = date('j', strtotime($current_date . ' +7 day'));
$e_hour = date('g', strtotime($current_date . ' +7 day'));
$e_min = date('i', strtotime($current_date . ' +7 day'));
	$e_min =	intval($e_min);	
$s_min =	intval($s_min);		

$media='';
		if($img_url !=''){
		$media = '"media": [
				{
				  "mediaFormat": "PHOTO",
				  "sourceUrl": "'.$img_url.'"
				}
			  ]';
		  }
		$json = '{
			 
			  "summary": "'.$event_description.'",
			    '.$callToAction.'
			  "event": {
				"title": "'.$event_title.'",
				"schedule": {
					"startDate": {
						"year": '.$s_year.',
						"month": '.$s_month.',
						"day": '.$s_date.'
					  },
					  "startTime": {
						  "hours": '.$s_hour.',
						  "minutes": '.$s_min.',
						  "seconds": 0,
						  "nanos": 0
					  },
					  "endDate": {
						"year": '.$e_year.',
						"month": '.$e_month.',
						"day": '.$e_date.'
					  },
					  "endTime": {
						    "hours": '.$e_hour.',
						  "minutes": '.$e_min.',
						  "seconds": 0,
						  "nanos": 0
					  },
				}
			  },
			  '.$media.'
			}';

//print_r($json); die;
 try {
	 
		if($request->input('schedule_option') == 2){
				$gmb_post_id_arr = array();
				$resObj = DB::table('scheduled_gmb_events')->where('post_id', $id)->get();
				
				foreach($resObj as $response){
					
					$gmb_post_ids = explode(',',$response->gmb_post_id); print_r($gmb_post_ids);
					foreach($gmb_post_ids as $gmb_id){
						array_push($gmb_post_id_arr,$gmb_id);
					}
				
				}
		}
		
		$state ='';
         foreach( $gmb_post_id_arr as  $gmb_post_id){
       
	 	$endpoint = 'https://mybusiness.googleapis.com/v4/'.$gmb_post_id.'?updateMask=summary,media.sourceUrl,callToAction.actionType,callToAction.url,event.title';	
		$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
		$response = $client->request('PATCH', $endpoint, ['body' => $json]);

 
		  $content = $response->getBody();// die;
		$contentArr = json_decode($content); //echo "<pre>"; print_r($contentArr); die;
		if($contentArr){ $state= $contentArr->state; }
		} 

		 $post = Posts::create($request->all());
		 $post->title= $request->get('event_title');
		 $post->description= $request->get('event_description');
		 $post->img_url= $request->get('img_url');
		 $post->location= implode(',',$request->get('location'));
		 $post->button= $request->get('add_button');
		 $post->button_name= $request->get('button_name');
		 $post->button_url= $request->get('button_url');
		 $post->video= $filename;
		 $post->image= $imageName;
		 $post->schedule_option= $request->get('schedule_option');
		 $post->timezone= $request->get('timezone');
		 $post->repeat_post= $request->get('repeat_post');
		 $post->repeat_option= $request->get('repeat_option');
		 $post->event_expire= $request->get('event_expire');
		// $post->gmb_post_id= $contentArr->name;
		$post->status= $state;
		 //$post = (array)$post;
		 $res = Posts::where('id', $id)->update(['title' => $post->title,'description'=>$post->description,'location'=>$post->location, 'button_name' => $post->button_name ,'button' => $post->button,'button_url' => $post->button_url,'img_url' => $post->img_url ]);
		// $post->save();

} catch (\Exception $ex) {
 	 //die((string)$ex->getResponse()->getBody());
      // print_r($ex); die;
		$msg=	$ex->getMessage();
			return redirect('edit-post/'.$id)->with('message', 'Something went wrong. Try again later.'.$msg);
		 }
		return redirect('edit-post/'.$id)->with('message', 'You Post has been successfully updated.');
	}
	
	
	/*
	 *  Function for creating scheduled posts
	 *  This fn will be executed by cron 
	 */
	 
	 	function generateGmbAccessToken2($user_id){
		
		    
        $userId = $user_id; 
        
        $GOOGLE_SECRET_ID =  config('app.GOOGLE_SECRET_ID');  
		$GOOGLE_CLIENT_ID =  config('app.GOOGLE_CLIENT_ID'); 
		
		$userData = DB::table('oauth')->where(['user_id' => $userId ])->first();
		$token = json_decode($userData->token);
		$refresh_token = $token->refresh_token; 
		
		
		
		//~ $client_id = '1075153362334-vlu4u4ikm4ggcuk73g0rpp0m994p5hg7.apps.googleusercontent.com';
		//~ $client_secret = 'jOTgIXDxHKeP3Ii5Vy3Mwm-h';
		//$refresh_token = '1/Lrza_G49NJmEPtsKUA429faLdOa8zmuAxHVjd5sjMbBE7cNZWzOyi_ZfvCPB_VNl'; 
		//1/zomIw2x1HQ1VOTWLcPOlhKp-D2s1rOvP0BUGav7GodeIUilJUPVmMDKxDCx8bP2F
		$endpoint = 'https://www.googleapis.com/oauth2/v4/token';	
		$client = new \GuzzleHttp\Client();
		$response = $client->request('POST', $endpoint, ['query' => [
				'client_id' => $GOOGLE_CLIENT_ID, 'client_secret' => $GOOGLE_SECRET_ID, 'refresh_token' => $refresh_token,'grant_type'=> 'refresh_token' 
				]]);

		$statusCode = $response->getStatusCode();
		$content = $response->getBody(); 
		$dataArr = json_decode($content);
		$access_token =  $dataArr->access_token; 
		return $access_token;
		
	}
	
	
	
	 public function createScheduledPosts()
    { 
	
		
								
		 DB::table('cron_record')->insert(['post_id' => 5 ]);						
		
		 
		$data = Posts::where('schedule_option', '=', '2')->where('remaining_posts', '!=', '0')->get();
	//print_r($data); die;
		foreach($data as $post){
			$user_id = $post->user_id;
			$access_token = $this->generateGmbAccessToken2($user_id);
			$post_id = $post->id;
			$event_title= $post->description;
			$event_description= $post->title;
			$locations= explode(',',$post->location);
			$button= $post->button;
			$button_name= $post->button_name;
			$button_url= $post->button_url;
			$video= $post->video;
			$image= $post->image;
			$start_date= $post->start_date;$start_date1= $post->start_date;
			$schedule_option= $post->schedule_option;
			 $timezone= $post->timezone;
			$time= $post->time;
			$repeat_post= $post->repeat_post;
			$repeat_option= $post->repeat_option;
			$location= $post->location;
			$event_expire= $post->event_expire;
			$expire_check= $post->expire_check;
			$remaining_posts= $post->remaining_posts;
			date_default_timezone_set($timezone);
			$baseUrl = url('/');
			$img_url= $post->img_url;
			$current_date = date('Y-m-d H:i');
			if($image != ''){
			$img_url = $baseUrl.'/images/'.$image; 
			}
			
			
		//	DB::table('cron_record')->insert(['post_id' => $access_token ]);
				if($button == 1){
			$callToAction='"callToAction": {
					"actionType": "'.$button_name.'",
					"url": "'.$button_url.'",
				  },';
		}else{
			$callToAction='';
			
		}
		$media='';
		if($img_url !=''){
		$media = '"media": [
				{
				  "mediaFormat": "PHOTO",
				  "sourceUrl": "'.$img_url.'"
				}
			  ]';
		  }

    // than convert it to IST by

    
	 $start_date = $start_date. ' '.$time ;		
		$s_year = date('Y', strtotime($start_date));
		$s_month = date('n', strtotime($start_date));
		$s_date = date('j', strtotime($start_date));
		
		$s_hour = date('g', strtotime($start_date));
		$s_min = date('i', strtotime($start_date));

 $e_year = date('Y', strtotime($start_date . ' +7 day'));
$e_month = date('n', strtotime($start_date . ' +7 day'));
$e_date = date('j', strtotime($start_date . ' +7 day'));
$e_hour = date('g', strtotime($start_date . ' +7 day'));
$e_min = date('i', strtotime($start_date . ' +7 day'));
	$e_min =	intval($e_min);	
$s_min =	intval($s_min);	
			
			
			$json = '{
			   "languageCode": "en-US",
			  "summary": "'.$event_description.'",
			    '.$callToAction.'
			  "event": {
				"title": "'.$event_title.'",
				"schedule": {
					"startDate": {
						"year": '.$s_year.',
						"month": '.$s_month.',
						"day": '.$s_date.'
					  },
					  "startTime": {
						  "hours": '.$s_hour.',
						  "minutes": '.$s_min.',
						  "seconds": 0,
						  "nanos": 0
					  },
					  "endDate": {
						"year": '.$e_year.',
						"month": '.$e_month.',
						"day": '.$e_date.'
					  },
					  "endTime": {
						    "hours": '.$e_hour.',
						  "minutes": '.$e_min.',
						  "seconds": 0,
						  "nanos": 0
					  },
				}
			  },
			  '.$media.'
			}';
	//echo "<pre>";	echo $json; die;
		
		if($repeat_post == 'no-repeat'){ echo $current_date .' 111 '.$start_date;
			
			if($current_date == $start_date || $current_date >= $start_date){

				try {
					$gmb_post_id_arr = array();
						foreach($locations as $location){
					   
						$endpoint = 'https://mybusiness.googleapis.com/v4/'.$location.'/localPosts';	
						$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
						$response = $client->request('POST', $endpoint, ['body' => $json]);
						$statusCode = $response->getStatusCode(); 
						$content = $response->getBody();
						$contentArr = json_decode($content);
						$gmb_post_id = $contentArr->name ;
						array_push($gmb_post_id_arr, $gmb_post_id);
						}
						$local_date = date('Y-m-d');
						if($statusCode == 200){
							$gmb_post_ids = implode(',',$gmb_post_id_arr);
							$content = $response->getBody();//echo "<pre>"; print_r($content ); //die;
						$contentArr = json_decode($content);
								echo $remaining_posts = $remaining_posts - 1;
								echo $test = DB::table('scheduled_gmb_events')->insert(
									['post_id' => $post_id, 'st_date' => $local_date, 'time' =>$time,'gmb_post_id' => $gmb_post_ids ,'created_at_local'=>$local_date]
								);
								//if($count == 0){
								 $res = Posts::where('id', $post_id)->update(['remaining_posts' => $remaining_posts, 'gmb_post_id' => $gmb_post_ids]);
								//} 
							
						}
			 }
				catch (\Exception $ex) {
					$msg=	$ex->getMessage();
					//~ //die((string)$ex->getResponse()->getBody());
								 echo 'failure:'.$post_id.$msg;
					 
						
							//~ //echj
						}
				 }

		}else{
			 // Repeat Code begins here
			
			$res = DB::table('scheduled_gmb_events')->where('post_id', $post_id)->orderBy('id', 'desc')->limit(1)->get();
			echo $post_id;
			echo '<pre>';
			
			$count =count($res);
		//	if($post_id == 86){  print_r(count($res)); }
		if($count == 0){
			$res=array();
			 $time = $post->time;$start_date = $post->start_date;
			$res[0]['st_date']= $start_date;
			$res[0]['time']= $time;
			 $res[0]['created_at']= $start_date.' '.$time;
			$res=(object)$res;
			 }
			//if($res){ echo $res->items->created_at; }
			foreach($res as $result1){ $result1=(object)$result1; //print_R($result1); 
				//echo $date1 = $result1->st_date; 
				//$time1 = $result1->time;//die;
				//$st_date = date('Y-m-d', strtotime($res->created_at));
				$st_date = $result1->st_date;$time1 = $result1->time;
				  $last_created_at = $st_date.' '.$time1;// die;
				 	 $start_date =$last_created_at;	
		$s_year = date('Y', strtotime($start_date));
		$s_month = date('n', strtotime($start_date));
		$s_date = date('j', strtotime($start_date));
		
		$s_hour = date('g', strtotime($start_date));
		$s_min = date('i', strtotime($start_date));

 $e_year = date('Y', strtotime($start_date . ' +7 day'));
$e_month = date('n', strtotime($start_date . ' +7 day'));
$e_date = date('j', strtotime($start_date . ' +7 day'));
$e_hour = date('g', strtotime($start_date . ' +7 day'));
$e_min = date('i', strtotime($start_date . ' +7 day'));
	$e_min =	intval($e_min);	
$s_min =	intval($s_min);	
				 $json = '{
			   "languageCode": "en-US",
			  "summary": "'.$event_description.'",
			    '.$callToAction.'
			  "event": {
				"title": "'.$event_title.'",
				"schedule": {
					"startDate": {
						"year": '.$s_year.',
						"month": '.$s_month.',
						"day": '.$s_date.'
					  },
					  "startTime": {
						  "hours": '.$s_hour.',
						  "minutes": '.$s_min.',
						  "seconds": 0,
						  "nanos": 0
					  },
					  "endDate": {
						"year": '.$e_year.',
						"month": '.$e_month.',
						"day": '.$e_date.'
					  },
					  "endTime": {
						    "hours": '.$e_hour.',
						  "minutes": '.$e_min.',
						  "seconds": 0,
						  "nanos": 0
					  },
				}
			  },
			  '.$media.'
			}';
				 
				 if($count == 0){
					 $repeat_option = '0 day';
				 }
				 
				
					 $repeat_option;
					 $last_created_at; 
					echo  $next_post_date = date('Y-m-d H:i', strtotime($last_created_at . '+'.$repeat_option)); //die;
					echo  $current_date = date('Y-m-d H:i');// echo "<br>"; die;
					//echo strtotime($current_date); echo "<br>";
			//echo strtotime($start_date);
					if($current_date == $next_post_date ){
			echo 'match';
				try {
					$gmb_post_id_arr = array();
						 foreach($locations as $location){
					   
						$endpoint = 'https://mybusiness.googleapis.com/v4/'.$location.'/localPosts';	
						$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
						$response = $client->request('POST', $endpoint, ['body' => $json]);
						 $statusCode = $response->getStatusCode(); 
						 $content = $response->getBody();
						$contentArr = json_decode($content);
						$gmb_post_id = $contentArr->name ;
						array_push($gmb_post_id_arr, $gmb_post_id);
						 
						}
						 $local_date = date('Y-m-d');
						if($statusCode == 200){
							$gmb_post_ids = implode(',',$gmb_post_id_arr);
							$content = $response->getBody();//echo "<pre>"; print_r($content ); //die;
						$contentArr = json_decode($content);
								echo $remaining_posts = $remaining_posts - 1;
								echo $test = DB::table('scheduled_gmb_events')->insert(
									['post_id' => $post_id, 'st_date' => $local_date, 'time' =>$time,'gmb_post_id' => $gmb_post_ids,'created_at_local'=>$local_date]
								);
								if($count == 0){
								 $res = Posts::where('id', $post_id)->update(['remaining_posts' => $remaining_posts, 'gmb_post_id' => $gmb_post_ids]);
								} 
							
						}
						
						//~ $content = $response->getBody();//echo "<pre>"; print_r($content ); //die;
						//~ $contentArr = json_decode($content);
						
						//Save an entry in out db
						
								 
								
								 echo 'success:'.$post_id;
			 }
				catch (\Exception $ex) {
					//~ //die((string)$ex->getResponse()->getBody());
					$msg=	$ex->getMessage();
								 echo 'failure:'.$post_id.$msg;
					 
						
							//~ //echj
						}
				 }
				
				
			}
			echo "<br>";
			
			
			
			
			
			
			
		}
			
		}
       // return;
    }
    
    
    function SaveSchedulePost(Request $request){
		
		$user = Auth::User();     
        $userId = $user->id; 
        
        
		$post_id= $request->get('post_id');
		$data = Posts::where('id', '=', $post_id)->get();
		
		$title = $data[0]->title; 
		$description = $data[0]->description; 
		$img_url = $data[0]->img_url; 
		$location = $data[0]->location;
		$add_button = $data[0]->add_button;
		$button_name = $data[0]->button_name;
		$button_url = $data[0]->button_url;
		$video = $data[0]->video;
		$image = $data[0]->image;
		
		
		$post = Posts::create($request->all());
		 $post->title= $title;
		 $post->description= $description;
		 $post->img_url= $img_url;
		 $post->location= $location;
		 $post->button= $add_button;
		 $post->button_name= $button_name;
		 $post->button_url= $button_url;
		 $post->video= $video;
		 $post->image= $image;
		 $post->schedule_option= '2';
		 $post->start_date= $request->get('start_date');
		  $post->time= $request->get('time');
		  $post->timezone= $request->get('timezone'); //die;
		  $post->user_id= $userId; 
		
		 $post->repeat_post= $request->get('repeat');
		 $post->expire_check= $request->get('expire_check');
		 $post->repeat_option= $request->get('repeat_option');
		echo $post->event_expire= $request->get('event_expire');
		 //$post->remaining_posts= $request->get('event_expire');
		  if($request->get('repeat') == 'no-repeat'){
			 
			$post->remaining_posts= 1;
		 }else{
			 if($post->expire_check != 'on'){
				 $post->remaining_posts=100;
			 }else{
			$post->remaining_posts= $request->get('event_expire');
			}
		 }
		 if($request->get('event_expire') == ''){
			 $post->event_expire=1;
		 }
		 //~ echo "<pre>";
		 //~ print_r($post); die;
		 if($post->title != ''){
		 $post->save();
		}
		
		return redirect('schedule-post')->with('message', 'You Post has been successfully scheduled.');
	}
	
	
	
	function bulkImport(Request $request){
		 $postCount = $this->postCount(); 
		 return view('schedulebulkimport')->with(array('postCount'=> $postCount));
		
	}


	function processBulkImport(Request $request){
			$user = Auth::User();     
        $userId = $user->id; 
		$access_token = $this->generateGmbAccessToken();
			$filename=request()->file;
			$file = time().'.'.request()->file->getClientOriginalExtension(); 

			$filename=  request()->file->move(public_path('images'), $file);// die;
         
			if (!file_exists($filename) || !is_readable($filename)){
				return false;
			}
			
			$header = null;
			$data = array(); 
			$delimiter=",";
			
			if (($handle = fopen($filename, 'r')) !== false)
			{
				while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
				{
					if (!$header)
						$header = $row;
					else
					//print_r($header); print_r($row); die; 
						$data[] = array_combine($header, $row);
				}
				fclose($handle);
			}
$msg='';
			 try {
			foreach($data as $postData){
						 
					 $post = Posts::create($request->all());
					 $post->title= $postData['event_title'];
					 $post->description= $postData['event_description'];
					 $post->img_url= $postData['img_url'];
					 $post->location= $postData['location'];
					 $locations= explode(',',$postData['location']);
					 $locArr=array();
					 foreach($locations as $location){	
					 $res = DB::table('locations')->where('title', $location)->first();
										$raw_data = $res->raw_data;
										$raw_data_arr = json_decode($raw_data);
										 $locationID = $raw_data_arr->name; 
								array_push($locArr,	$locationID);	
					 
					}
					$locIds = implode(',',$locArr);
					$post->location=$locIds;
					 $post->button= $postData['add_button'];
					 $post->button_name= $postData['button_name'];
					 $post->button_url= $postData['button_url'];
					 $post->img_url= $postData['img_url'];
					 //~ $post->video= $filename;
					 //~ $post->image= $imageName;
					 $post->schedule_option= $postData['schedule_option'];
					// $post->start_date= $current_date;
					 
					 // $post->end_date= $end_date;
					 $post->time= $postData['post_time'];
					  $post->start_date= $postData['start_date'];
					 //$post->end_date= $postData['end_date'];
					 $post->timezone= $postData['timezone'];
					 $post->repeat_post= $postData['repeat_post'];
					 $post->expire_check= $postData['expire_check'];
					 $post->repeat_option=$postData['repeat_option'];
					 $post->event_expire= $postData['event_expire'];
					 $post->user_id= $userId;
					 if($postData['repeat_post'] == 'no-repeat'){
						 
						$post->remaining_posts= 1;
					 }else{
						 if($postData['expire_check'] != 'on'){
							 $post->remaining_posts=100;
						 }else{
						$post->remaining_posts= $postData['event_expire'];
						}
					 }
					 
					 
					 if($post->title != ''){
					 $post->save();
					 }
					 
					 if($postData['schedule_option'] == 1){
						 
						 $locations= explode(',',$postData['location']);
						 
						 // creating post 
							$event_title = $postData['event_title'];
							$event_description = $postData['event_description'];
							$button = $postData['add_button'];
							$button_name = $postData['button_name'];
							$button_url = $postData['button_url'];
							$img_url = $postData['img_url'];
							$time = $postData['post_time'];
							$start_date = $postData['start_date'];
							$timezone = $postData['timezone'];
						 date_default_timezone_set($timezone);
						 	if($button == 1){
									$callToAction='"callToAction": {
											"actionType": "'.$button_name.'",
											"url": "'.$button_url.'",
										  },';
								}else{
									$callToAction='';
									
								}
								$media='';
								if($img_url !=''){
								$media = '"media": [
										{
										  "mediaFormat": "PHOTO",
										  "sourceUrl": "'.$img_url.'"
										}
									  ]';
								  }

							// than convert it to IST by

							
							 $start_date = date('Y-m-d h:i:s') ;		
								$s_year = date('Y', strtotime($start_date));
								$s_month = date('n', strtotime($start_date));
								$s_date = date('j', strtotime($start_date));
								
								$s_hour = date('g', strtotime($start_date));
								$s_min = date('i', strtotime($start_date));

						 $e_year = date('Y', strtotime($start_date . ' +7 day'));
						$e_month = date('n', strtotime($start_date . ' +7 day'));
						$e_date = date('j', strtotime($start_date . ' +7 day'));
						$e_hour = date('g', strtotime($start_date . ' +7 day'));
						$e_min = date('i', strtotime($start_date . ' +7 day'));
							$e_min =	intval($e_min);	
						$s_min =	intval($s_min);	
									
									
									$json = '{
									   "languageCode": "en-US",
									  "summary": "'.$event_description.'",
										'.$callToAction.'
									  "event": {
										"title": "'.$event_title.'",
										"schedule": {
											"startDate": {
												"year": '.$s_year.',
												"month": '.$s_month.',
												"day": '.$s_date.'
											  },
											  "startTime": {
												  "hours": '.$s_hour.',
												  "minutes": '.$s_min.',
												  "seconds": 0,
												  "nanos": 0
											  },
											  "endDate": {
												"year": '.$e_year.',
												"month": '.$e_month.',
												"day": '.$e_date.'
											  },
											  "endTime": {
													"hours": '.$e_hour.',
												  "minutes": '.$e_min.',
												  "seconds": 0,
												  "nanos": 0
											  },
										}
									  },
									  '.$media.'
									}';
						 
						
							 $gmb_post_id_arr= array();
						 			foreach($locations as $location){	
										
										$res = DB::table('locations')->where('title', $location)->first();
										$raw_data = $res->raw_data;
										$raw_data_arr = json_decode($raw_data);
										 $locationID = $raw_data_arr->name; 
										
										
										   
									$endpoint = 'https://mybusiness.googleapis.com/v4/'.$locationID.'/localPosts';	
									$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
									$response = $client->request('POST', $endpoint, ['body' => $json]);
									echo $statusCode = $response->getStatusCode(); 
									$content = $response->getBody();
									$contentArr = json_decode($content);
									$gmb_post_id = $contentArr->name ;
									array_push($gmb_post_id_arr, $gmb_post_id);
									}
									$local_date = date('Y-m-d');
									if($statusCode == 200){
										$content = $response->getBody();//echo "<pre>"; print_r($content ); //die;
									$contentArr = json_decode($content);
											//~ echo $remaining_posts = $remaining_posts - 1;
											//~ echo $test = DB::table('scheduled_gmb_events')->insert(
												//~ ['post_id' => $post_id, 'st_date' => $local_date, 'time' =>$time,'gmb_post_id' => $contentArr->name ,'created_at_local'=>$local_date]
											//~ );
											
										
									} 
									//return redirect('/schedule-post-bulk-upload')->with('message', 'You Post(s) has been successfully scheduled.');
						 }
					 }
							
						 
						 
						 
					// }
			}catch (\Exception $ex) {
								//~ //die((string)$ex->getResponse()->getBody());
								
								$msg=	$ex->getMessage();
											 echo 'failure:'.$msg; 
								 
								//	return redirect('/schedule-post-bulk-upload')->with('message', 'Something went wrong. Please check csv format.');
										//~ //echj
						}
						 
			if($msg){
				return redirect('schedule-post-bulk-upload')->with('message', 'Something went wrong. Please try again later'.$msg);
			}else{
			return redirect('schedule-post-bulk-upload')->with('message', 'You Post(s) has been successfully scheduled.');
			}
	}
	
	
	/*
	 *  Function for fetching locations from GMB account
	 */
		 
	public function fetchLocations(){
		
		$locationsArr = array();
		$access_token = $this->generateGmbAccessToken(); 
		
		try{
			
			// fetching Location Groups
			
			$endpoint = 'https://mybusiness.googleapis.com/v4/accounts/';	

			$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
			$response = $client->request('GET', $endpoint);
			$statusCode = $response->getStatusCode();
			$content = $response->getBody();
			$dataObj = json_decode($content);			
			
			foreach($dataObj->accounts as $account){
				
				$path = $account->name;
				$name = $account->accountName;
				
				//fetching Locations
				
				$endpoint = 'https://mybusiness.googleapis.com/v4/'.$path.'/locations';	
				$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
				$response = $client->request('GET', $endpoint);
				$statusCode = $response->getStatusCode();
				$content = $response->getBody();
				$locationsObj = json_decode($content);
				
				if(isset($locationsObj->locations)){
					foreach($locationsObj->locations as $location){
						
						
						$location->locationGroupID = $path;
						$location->locationGroupName = $name;
						if(isset($location->locationState->isVerified)){
							if($location->locationState->isVerified == 1){
								array_push($locationsArr, $location);
							}
						}
					} // end foreach (locations)
				}
				
			} // end foreach (accounts)
			
			 return $locationsArr;
			 
			
			
		}catch(\Exception $ex){

			return $locationsArr;
		}
		
	}
	
	/*
	 *  Function for fetching the count of active, expired and scheduled posts
	 */
	
	function postCount(){
		
			$user = Auth::User();     
			$userId = $user->id; 
        
			$expired_posts = Posts::where('user_id', '=', $userId)->where('remaining_posts', '0')->get();
			$active_posts = Posts::where('user_id', '=', $userId)->where('remaining_posts', '!=', '0')->get();
			$scheduled_posts = Posts::where('user_id', '=', $userId)->where('remaining_posts', '!=', '0')->where('schedule_option', '=', '2')->get();
			
			$dataArr = array();
			$dataArr['expired_posts_count'] = count($expired_posts);
			$dataArr['active_posts_count'] = count($active_posts);
			$dataArr['scheduled_posts_count'] = count($scheduled_posts);
			
			return (object)$dataArr;
	}
	
	/*
	 *  Function for fetching list of posts 
	 * 
	 */
	public function index1(Request $request){

        if ($request->ajax()) {

            $data = Posts::latest()->get();
          $postViews= $this->fetchPostViews();
            foreach($data as $dataArr){
				$dataArr['type'] = 'Event';
				
				$current_date = $dataArr['start_date'];
			$expiry_date = date('Y-m-d ', strtotime($current_date . ' +7 days'));
				$dataArr['expiry_date'] = $expiry_date;
				
				$views='';
				if($dataArr['schedule_option']== '1'){
					$gmb_post_ids =	explode(',',$dataArr->gmb_post_id);
					
					foreach($gmb_post_ids as $gm_id){
						if(array_key_exists($gm_id,$postViews)){
							$views = $postViews[$gm_id];
						}else{ $views = 0; }
					}	
					
				}else{
					
					
					$response = DB::table('scheduled_gmb_events')->where('post_id', $dataArr->id)->get();
					foreach($response as $res){
					$gmb_post_ids = explode(",",$res->gmb_post_id);
					foreach($gmb_post_ids as $gm_id){
						if(array_key_exists($gm_id,$postViews)){
							$views = $postViews[$gm_id];
						}else{ $views = 0; }
					}
					}
					
				}
				$dataArr['views'] = $views; 
			//~ $endpoint = 'https://mybusiness.googleapis.com/v4/accounts/';	

			//~ $client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
			//~ $response = $client->request('GET', $endpoint);
			//~ $statusCode = $response->getStatusCode();
			//~ $content = $response->getBody();
			//~ $dataObj = json_decode($content);	
								
			}
			//print_r($data); die;
            return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('action', function($row){
							//$baseUrl = route('schedule', ['id' => $row['id']]);

                           $btn = '<a href="edit-post/'.$row['id'].'" class="edit"><i aria-hidden="true" class="fa fa-pencil text-secondary font-20 mr-1"></i></a><a href="schedule/'.$row['id'].'" class="edit "><i aria-hidden="true" class="fa fa-clock-o text_dark_pink font-20 mr-1"></i></a><a style="cursor:pointer;" class="edit" onclick="deletePost('.$row['id'] .');"><i aria-hidden="true" class="fa fa-ban font-20 text_red"></i></a>';

                            return $btn;

                    })

                    ->rawColumns(['action'])

                    ->make(true);

        }

        return view('manage-posts');

    }
    
    /*
     *  Function for fetching Post Views
     */
     
    function fetchPostViews(){
		
		$user = Auth::User();     
		$userId = $user->id; 
		$userPosts = Posts::where('user_id', '=', $userId)->get();

		$localPostNames = array();
		
		
		foreach($userPosts as $userPost){
			$postid =$userPost->id; //die;
			if( $userPost->schedule_option == 1){
				
				$gmb_post_ids = explode(",",$userPost->gmb_post_id);
				foreach($gmb_post_ids as $gm_id){
				array_push($localPostNames, $gm_id);
				}
				
			}else{
				//echo $postid; die;
				$response = DB::table('scheduled_gmb_events')->where('post_id', $postid)->get();
				foreach($response as $res){
				$gmb_post_ids = explode(",",$res->gmb_post_id);
				foreach($gmb_post_ids as $gm_id){
				array_push($localPostNames, $gm_id);
				}
					
				}
				
			//	$localPostNames[]= '2';
				
			}
			
			
		}
	//	echo "<pre>";
		$gmidsjson = json_encode($localPostNames);
		$access_token = $this->generateGmbAccessToken(); 
		$json='{
    "localPostNames": [
        '.$gmidsjson.'
    ],
    "basicRequest": {
        "metricRequests": [
            {
                "metric": "LOCAL_POST_VIEWS_SEARCH"
            }
        ],
        "timeRange": {
            "startTime": "2018-07-10T00:00:00.000000000Z",
            "endTime": "2019-10-17T00:00:00.000000000Z"
        }
    }
}';
		$endpoint = 'https://mybusiness.googleapis.com/v4/accounts/110858452171291353127/locations/13399109068475708528/localPosts:reportInsights';	

			$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
			$response = $client->request('POST', $endpoint, ['body' => $json]);
			$statusCode = $response->getStatusCode();
			$content = $response->getBody();
			$dataObj = json_decode($content);	
			$arr = (array)$dataObj->localPostMetrics;
			//$a=array_column($arr, 'localPostName', 'metricValues'); print_r($a); die;
			
			$newArr= array();
			foreach($dataObj->localPostMetrics as $postname){
				$localPostName = $postname->localPostName;
				$newArr[$localPostName] = $postname->metricValues[0]->totalValue->value;
				
			} 
			
			
			
			  //~ $data = Posts::latest()->get();
           //~ $postViews= $newArr;
            //~ foreach($data as $dataArr){
				//~ $dataArr['type'] = 'Event';
				//~ $views='';
				//~ if($dataArr['schedule_option']== '1'){
					//~ $gmb_post_ids =	explode(',',$dataArr->gmb_post_id);
					
					//~ foreach($gmb_post_ids as $gm_id){
						//~ if(array_key_exists($gm_id,$postViews)){
							//~ $views = $postViews[$gm_id];
						//~ }else{ $views = ''; }
					//~ }	
					
				//~ }else{
					
					
					//~ $response = DB::table('scheduled_gmb_events')->where('post_id', $dataArr->id)->get();
					//~ foreach($response as $res){
					//~ $gmb_post_ids = explode(",",$res->gmb_post_id);
					//~ foreach($gmb_post_ids as $gm_id){
						//~ if(array_key_exists($gm_id,$postViews)){
							//~ $views = $postViews[$gm_id];
						//~ }else{ $views = ''; }
					//~ }
					//~ }
					
				//~ }
				//~ echo $dataArr['views'] = $views; 
				
			//~ }
				//~ die;
			
			
			
			
			return $newArr;
			
	} 
}


