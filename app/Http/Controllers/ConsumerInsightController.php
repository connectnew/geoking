<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\gmb\lib\Google_my_business;
use App\Posts;
use DB;
use DateTimeZone;
use Auth;

class ConsumerInsightController extends Controller
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
		$user = Auth::User();     
        $userId = $user->id; 
					
		$locations = DB::table('locations')
					->join('account_users', 'account_users.id', '=', 'locations.account_id')->select('locations.*', 'account_users.user_id',)
					->where('user_id','=', $userId)->get();
				
            
	  $words = $this->fetchGoogleReviewsWord();
	  $reviewsArr = $this->fetchGoogleReviews();
      return view('consumerinsight')->with(array('reviewsArr'=> $reviewsArr , 'words' => $words, 'locations'=> $locations));;
    }
    
    /*
	 *  Function for fetching reviews from database
	 */
    
    public function fetchGoogleReviews(){
		
		$reviewsArr = array();
		$posts = new PostController();
		$access_token = $posts->generateGmbAccessToken(); 
		
		$reviewArr = DB::table('reviews')->get();
		return $reviewArr;
	}
    
    /*
	 *  Function for generating cloudword from database reviews
	 */
    
    public function fetchGoogleReviewsWord(){
		
		$reviewsArr = array();
		$posts = new PostController();
		$access_token = $posts->generateGmbAccessToken(); 
		
		$reviewArr = DB::table('reviews')->get();
		
		$commenttext = '';
		foreach($reviewArr as $review){
			 $comment = $review->comment;
			 $commenttext .= $comment;
		}
		
		$words = $this->extractCommonWords($commenttext); 
		$wordsArr= array();
		
		foreach($words as $key => $value){
			$arr = array();
			$arr["tag"] = $key;
			$arr["count"] = $value;
			array_push($wordsArr, $arr);
			
		}
		
		$wordCountArr = json_encode($wordsArr);
		return $wordCountArr;
	}
  
  	/*
	 *  Function for filtering cloudword widget
	 */
	 
	   
   function filterReviews(Request $request){
	   
	   $rating = $request->get('rating');
	   $locationArr = $request->get('location');
	   $period = $request->get('period');
	     
		$dateS = $period;
		$dateE = date('Y-m-d');
	   
	   $query= DB::table('reviews');
	    if ($rating != '') {
		  $query = $query->where('rating','=', $rating);
		}
		if ($period != '') {
		  $query = $query->whereBetween('created_at',[$dateS,$dateE]);
		}
		if (!empty($locationArr)) { 
		  $query = $query->whereIn('location_id',$locationArr);

		}
		$reviewArr = $query->get();
		
	   $commenttext = '';
		foreach($reviewArr as $review){
			 $comment = $review->comment;
			 $commenttext .= $comment;
		}
		
		$words = $this->extractCommonWords($commenttext); 
		$wordsArr= array();
		
		foreach($words as $key => $value){
			$arr = array();
			$arr["tag"] = $key;
			$arr["count"] = $value;
			array_push($wordsArr, $arr);
			
		}
		
		$wordCountArr = json_encode($wordsArr);
		$wordCountArr = str_replace('[','',$wordCountArr);$wordCountArr = str_replace(']','',$wordCountArr);
		echo $wordCountArr;
   }
	
	/*
	 *  Function for extracting keywords from the reviews
	 */
	 
	public function extractCommonWords($string)
	{
		$stopWords = array('i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','the','www','have','has','had','they','them','which');

		$string = preg_replace('/ss+/i', '', $string);
		$string = trim($string);
		$string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
		$string = strtolower($string); // make it lowercase
	   // echo $string."<br>";

		preg_match_all('/\b.*?\b/i', $string, $matchWords);
		
	  
		$matchWords = $matchWords[0];
		//print_R($matchWords);
		$totalWords = count($matchWords);

		foreach ( $matchWords as $key=>$item ){
			if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
				unset($matchWords[$key]);
			}
		}

		$wordCountArr = array();
		if ( is_array($matchWords) ) {
			foreach ( $matchWords as $key => $val ) {
				$val = strtolower($val);
				if (isset($wordCountArr[$val])){
					$wordCountArr[$val] += 1;
				} else {
					$wordCountArr[$val] = 1;
				}
			}
			arsort($wordCountArr);
		}
		$wordCountArr= array_change_key_case($wordCountArr,CASE_UPPER); 
		$wordCountArr =array_slice($wordCountArr,0,50);
		if(empty($wordCountArr)){
			$wordCountArr["No Data Available"]= 2;
		}
	    //print_r($wordCountArr); die;
	 
		return $wordCountArr;
	}
	
	
	/*
	 *  Function for fetching Google reviews from API
	 */
	 
	public function fetchGoogleReviewsfromApi(){
		
		$reviewsArr = array();
		$posts = new PostController();
		$access_token = $posts->generateGmbAccessToken(); 
		
		try{
			
			$endpoint = 'https://mybusiness.googleapis.com/v4/accounts/';	

			$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
			$response = $client->request('GET', $endpoint);
			$statusCode = $response->getStatusCode();
			$content = $response->getBody();
			$dataObj = json_decode($content);
			//~ echo "<pre>";
			//~ print_r($dataObj);
			foreach($dataObj->accounts as $account){
				
				$path = $account->name;
				$name = $account->accountName;
				
				//fetching LOCATIONS
				$endpoint = 'https://mybusiness.googleapis.com/v4/'.$path.'/locations';	
				$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
				$response = $client->request('GET', $endpoint);
				$statusCode = $response->getStatusCode();
				$content = $response->getBody();
				$locationsObj = json_decode($content);
				//~ echo "<pre>";
				//~ print_r($locationsObj);
				
				if(isset($locationsObj->locations)){
					foreach($locationsObj->locations as $location){
						
						
						$path = $location->name;
						$name = $location->locationName;
						
						//fetching REVIEWS
						$endpoint = 'https://mybusiness.googleapis.com/v4/'.$path.'/reviews';	
						$client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer '.$access_token, 'Content-type'=> 'application/json']]);
						$response = $client->request('GET', $endpoint);
						$statusCode = $response->getStatusCode();
						$content = $response->getBody();
						$reviewsObj = json_decode($content);
						//~ echo "<pre>";
						//~ print_r($reviewsObj); 
						if(isset($reviewsObj->reviews)){
							foreach($reviewsObj->reviews as $review){
								if(isset($review->comment)){
									array_push($reviewsArr,$review);
								}
							
							} // end foreach (reviews)
						} // end if (reviews)
						
						
					} // end foreach (locations)
				}
				
			} // end foreach (accounts)
			
			 return $reviewsArr;
			 
			
			
		}catch(\Exception $ex){

			return $reviewsArr;
		}
	}
    
}
