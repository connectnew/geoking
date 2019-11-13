<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\gmb\lib\Google_my_business;
use App\Competition;
use App\Teams;
use DB;
use DateTimeZone;
use Auth;

class ProfileController extends Controller
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
     * Show the consumer insight dashboard.
     *
     * @return Response
     */
    public function show()
    {
		$userinfo = $this->fetchUser();
      return view('profile')->with(array('userinfo'=> $userinfo));
    }
    
    
    public function showTeams()
    {
		 $baseUrl = url('/');
		 $image_path=$baseUrl.'/team-images/';
	  $teamArr = $this->fetchTeam();
      return view('teams')->with(array('teamArr'=> $teamArr,'image_path'=>$image_path));
    }
   
    public function showCompetition()
    {
		$competitors = $this->fetchCompetitors();
		return view('competition')->with(array('competitors'=> $competitors));
    }
    
    public function updateCompetition( Request $request )
    {
		$user = Auth::User();     
        $userId = $user->id; 
        
		$cid = $request->input('cid'); 
		$competitor = $request->input('competitor'); 
		         
		$data = Competition::where('user_id', '=', $userId)->first();
		if(!empty($data)){ 
			
			$competitors = json_decode($data->competition,true);
			$competitors['competitor_'.$cid] = $competitor;
			
			$competitor_json = json_encode($competitors);
			$res = Competition::where('user_id', $userId)->update(['competition' => $competitor_json ]);
		}else{
			$competitor_arr = array();

			$competitor_arr['competitor_'.$cid] = $competitor;
			$competitor_json = json_encode($competitor_arr);
			$competition = new Competition;
			$competition->user_id = $userId;
			$competition->competition = $competitor_json;
			$res = $competition->save();						
		}
		
		if($res == 1){
			echo 'Competitor has been successfully updated';
		}else{
			echo 'Something went wrong. Try again later';
		}
    }
   
	/*
	 *  Function for fetching Competitors
	 */ 
     public function fetchCompetitors()
     {
		$user = Auth::User();     
        $userId = $user->id; 

		         
		$data = Competition::where('user_id', '=', $userId)->first();
		if(!empty($data)){ 
			$competitors = json_decode($data->competition);	
		}else{ $competitors = json_decode(array());   }
		
		return $competitors;
	 }
	 
	 /*
	  *  Function for updating user's email
	  */ 
	 public function updateUserEmail( Request $request )
     {
		$user = Auth::User();     
         $userId = $user->id; 
        
		 $email = $request->input('email'); 
		  	$res = DB::table('users')->where(['id' => $userId ])->update(['email' => $email ]);  
		// $res = DB::table('users')->where(['id' => $userId ])->update(['email' => $email ]);   
		 
		if($res == 1){
			echo 'Email has been successfully updated';
		}else{
			echo 'Email has been successfully updated';
		}
	 }
	 
	 /*
	  *  Function for updating user's Name
	  */ 
	  public function updateUserName( Request $request )
     {
		$user = Auth::User();     
		$userId = $user->id; 
        
		$name = $request->input('name'); 
		$res = DB::table('users')->where(['id' => $userId ])->update(['name' => $name ]);  
		  
		if($res == 1){
			echo 'Full Name has been successfully updated';
		}else{
			echo 'Full Name has been successfully updated';
		}
	 }
	 
	/*
	 *  Function for updating user's company 
	 */ 
	 
	 public function updateUserCompany( Request $request )
     {
		$user = Auth::User();     
		$userId = $user->id; 
        
		$company = $request->input('company'); 
		$res = DB::table('users')->where(['id' => $userId ])->update(['company' => $company ]);  
		  
		if($res == 1){
			echo 'Company has been successfully updated';
		}else{
			echo 'Company has been successfully updated';
		}
	 }
	 
	 /*
	  *  Function for fetching team members
	  */ 
	 public function fetchTeam()
     {
		$user = Auth::User();     
		$userId = $user->id; 
		$response = DB::table('user_teams')->where(['user_id' => $userId])->get();   
		$teamArr = array();
		foreach($response as $res){
			$role=$res->role;
			$teamArr[$role] = json_decode($res->data);
		}

		return (object)$teamArr;
	 }
	 
	 /*
	  *  Function for fetching team Uset
	  */ 
	 public function fetchUser()
     {
		$user = Auth::User();     
		$userId = $user->id; 
		$response = DB::table('users')->where(['id' => $userId])->first();   
	

		return $response;
	 }
	 
	 
	 /*
	  *  Function for updating Team
	  */
	  
	 public function updateTeam( Request $request )
     {
 
		$user = Auth::User();     
		$userId = $user->id; 
        
        
		$nameArr=$request->input('name'); 
        $emailArr=$request->input('email'); 
        $instantalertArr=$request->input('instant_alert'); 
        $execsummaryArr=$request->input('exec_summary'); 
        $frequencyArr=$request->input('frequency'); 
        
        $filenameArr = array();
		for($i=1;$i<=7; $i++){ 
			 $filename = 'file_'.$i;
			if(request()->$filename){
			//	echo 'test';
		        request()->validate([

            $filename => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
            $imageName = time().$i.'.'.request()->$filename->getClientOriginalExtension();
           request()->$filename->move(public_path('team-images'), $imageName);
		
		$filenameArr[$filename]=$imageName;
		}
			
		}	
      //  print_r($filenameArr);	
      // die;
        $i=0;
       
        $roleArr= array('marketing_manager','sales_manager','operations_manager','hr_manager', 'it_manager','brand_experience','customer_support');
        $res =1;
        foreach($nameArr as $name){
			$dataArr=array();
			$dataArr['name'] = $nameArr[$i];
			$dataArr['email'] = $emailArr[$i];
			if(in_array('instant_'.$i, $instantalertArr)){
				$dataArr['instant_alert'] = 1;
			}else{
				$dataArr['instant_alert'] = 0;
			}
			if(in_array('exec_'.$i, $execsummaryArr)){
				$dataArr['exec_summary'] = 1;
			}else{
				$dataArr['exec_summary'] = 0;
			}
			
						$role=$roleArr[$i];
			$k= $i+1;
			if($request->input('remove_'.$k) != '1'){ 
				if(array_key_exists('file_'.$k, $filenameArr)){ 
					$dataArr['photo'] = $filenameArr['file_'.$k];
				}else{
					
					$response =DB::table('user_teams')->where('role' , $role )->where('user_id' , $userId )->first();   
						if($response){
						$memberDataArr = json_decode($response->data);
						$photo = $memberDataArr->photo;
						echo $dataArr['photo'] = $photo;
						}
				}
			}
			else{
				$dataArr['photo'] = '';
			}

		//	if(isset($instantalertArr[$i])){ $dataArr['instant_alert'] = $instantalertArr[$i]; }else{ $dataArr['instant_alert'] = 0;  }
			//if(isset($execsummaryArr[$i])){ $dataArr['exec_summary'] = $execsummaryArr[$i]; }else{ $dataArr['exec_summary'] = 0;  }
			$dataArr['frequency'] = $frequencyArr[$i];
			//$dataArr['photo'] ='';

			$data_json = json_encode($dataArr); //print_r($data_json);
			//$response = Teams::where(['user_id' , $userId ])->get(); 
			 $response =DB::table('user_teams')->where('role' , $role )->where('user_id' , $userId )->get();   
		   $count = count($response);// die;
			if($count >= 1){
				echo  $data_json; echo "<br>";
				$res = Teams::where('role' , $role )->where('user_id' , $userId )->update(['data' => $data_json ]);  
			}else{
				$res = DB::table('user_teams')->insert(['user_id' => $userId, 'role' => $role, 'data' => $data_json ]);
				
			}
			$i++;
			}
			//print_r($res);
			//die;
			if($res != 0){
				return redirect('/teams')->with('message', 'You Team has been successfully updated.');
			}else{
				
				return redirect('/teams')->with('message', 'Something went wrong. Please try again later');
			}
			
		
	 }
	 
	 /*
	  *  Function for saving all competitors 
	  */ 
	 
	 public function saveCompetitors( Request $request  ){
		
		$user = Auth::User();     
        $userId = $user->id; 
        
		$competitors=array();
		for($i=1;$i<=10;$i++){
			
			$competitor = $request->input('competitor_'.$i); 
			$competitors['competitor_'.$i]=$competitor ;
		}
		 $competitor_json = json_encode($competitors);        
		$data = Competition::where('user_id', '=', $userId)->first();
		if(!empty($data)){ 
			
			
			
			$res = Competition::where('user_id', $userId)->update(['competition' => $competitor_json ]);
		}else{
			$competitor_arr = array();

			$competition = new Competition;
			$competition->user_id = $userId;
			$competition->competition = $competitor_json;
			$res = $competition->save();						
		}
		
		if($res == 1){
			return redirect('/competition')->with('message', 'Competitors has been successfully updated');
			
		}else{
			return redirect('/competition')->with('message', 'Competitors has been successfully updated');

			
		} 
		 
		 
	 }
}
