<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use PDOException;
use Validator;
use App\ReviewCategory;
use App\ReviewLanguage;
use App\AccountDomain;
use App\ReviewSmartResponse;
use Illuminate\Support\Facades\Auth;


class SmartResponseController extends Controller
{
    public function getAllCategory(Request $request): JsonResponse
    {
        if(isset($request->category) && $request->category){
            $category = ReviewCategory::where('show', 1)->orderBy('position', 'asc')->get();
            $result['category'] = $category;
        }
        if(isset($request->sector) && $request->sector){
            $sector = AccountDomain::orderBy('title', 'asc')->get();
            $result['sector'] = $sector;
        }
        if(isset($request->language) && $request->language){
            $language = ReviewLanguage::where('show', 1)->orderBy('position', 'asc')->get();
            $result['language'] = $language;
        }

        $result['auth'] = false;
        $result['auth_is_admin'] = false;

        return response()->json($result);
    }

    public function getByCategory(Request $request): JsonResponse
    {
        $query = ReviewSmartResponse::orderBy('id', 'asc');

        if(isset($request->category_id) && $request->category_id){
            $query->where('category_id', $request->category_id);
        }
        if(isset($request->language_id) && $request->language_id){
            $query->where('language_id', $request->language_id);
        }
        if(isset($request->sector_id) && $request->sector_id){
            $query->where('sector_id', $request->sector_id);
        }
        if(isset($request->positive) && $request->positive != null){
            $query->where('positive', $request->positive);
        }
        if(isset($request->search) && $request->search){
            $query->where('text', 'like', "%$request->search%");
        }

        if(isset($request->period) && $request->period){
            switch($request->period){
                case "day_7" :
                    $query->where( 'created_at', '>', Carbon::now()->subDays(7));
                    break;
                case "1_month" :
                    $query->where( 'created_at', '>', Carbon::now()->subMonths(1));
                    break;
                case "3_month" :
                    $query->where( 'created_at', '>', Carbon::now()->subMonths(3));
                    break;
                case "all" : break;
                default : break;
            }
        }

        $data = $query->paginate($request->per_page, ['*'], 'page', $request->page);

        return response()->json($data);
    }

    public function save(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only(['category_id', 'langauge_id', 'sector_id', 'positive', 'text']), [
            'category_id' => 'required|integer',
            'langauge_id' => 'required|integer',
            'sector_id' => 'required|integer',
            'positive' => 'required|integer',
            'text' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 200);
        }

        if($request->id){

            $data = ReviewSmartResponse::find($request->id);
            if(!$data){
                return response()->json(['status' => 'error', 'message' => 'Data not found'], 200);
            }

            $data->updated_by = Auth::user()->id;

        } else {

            $data = new ReviewSmartResponse();
            $data->created_by = Auth::user()->id;
        }

        $data->category_id = $request->category_id;
        $data->langauge_id = $request->langauge_id;
        $data->sector_id = $request->sector_id;
        $data->positive = $request->positive;
        $data->text = $request->text;

        try {
            $data->save();
        } catch (PDOException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }

        return response()->json(['status' => 'ok'], 200);
    }

    public function test()
    {
        $account = Auth::user()->accounts[0]->domain;

        dd($account);
    }


}

