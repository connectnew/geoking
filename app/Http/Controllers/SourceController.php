<?php

namespace App\Http\Controllers;

use App\Exports\SourcesExport;
use App\Imports\SourcesImport;
use App\Source;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class SourceController
 * @package App\Http\Controllers
 */
class SourceController extends Controller
{
    public function list()
    {
        try {
            $per_page = request()->per_page ? (int)request()->per_page : 10;
            $page = request()->page ? (int)request()->page : 1;
            //[$column, $direction] = request()->sort ? explode('|', request()->sort) : ['id', 'asc'];
            /** @var User $user */
            $user = auth()->user();
            $sources = $user->sources()->with('location')
                //->orderBy($column, $direction)
                ->paginate($per_page, ['*'], 'page', $page);

            return response()->json($sources);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(Request $request)
    {
        $source = Source::find($request->json('id'));
        if (!($source instanceof Source)) {
            return response()->json(['error' => 'Source not found.'], 404);
        }
        $source->gmb_place_id = $request->json('gmb_place_id');
        $source->save();

        $source = $source->with('location')->first();

        return response()->json($source);
    }

    public function import()
    {
        /** @var User $user */
        $user = auth()->user();

        $errorMessages = new Collection();
        $import = new SourcesImport($user);
        try {
            Excel::import($import, request()->file('sources'));

            foreach ($import->failures() as $failure) {
                foreach ($failure->toArray() as $item) {
                    $errorMessages->push($item);
                }
            }

            foreach ($import->errors() as $error) {
                $errorMessages->push($error->getMessage());
            }
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'There are some errors in the source file you\'ve uploaded',
                'errors' => [$e->getMessage()]
            ], 500);
        }

        if ($errorMessages->isEmpty()) {
            return response()->json(['status' => 'ok'], 200);
        }

        return response()->json([
            'message' => 'There are some errors in the source file you\'ve uploaded',
            'errors' => $errorMessages
        ], 400);
    }

    public function export(): BinaryFileResponse
    {
        /** @var User $user */
        $user = auth()->user();

        return Excel::download(new SourcesExport($user), sprintf('sources-%s.xlsx', Carbon::now()->format('Ymd-Hi')));
    }

    public function exportTemplate()
    {
        return response()->download(storage_path('/static/sources-template.xlsx'));
    }

    public function exportSample()
    {
        return response()->download(storage_path('/static/sources-sample.xlsx'));
    }

    public function exportAttributes()
    {
        return response()->download(storage_path('/static/sources-attributes.xlsx'));
    }
}
