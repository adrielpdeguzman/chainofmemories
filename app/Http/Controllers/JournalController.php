<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = new Journal;

        if ($request->has('q')) {
            $q = $request->input('q');
            $query = $query->where('contents', 'like', "%$q%")
                ->orWhere('events', 'like', "%$q%");
        }

        if ($request->has('embed')) {
            $query = $query->with($request->input('embed'));
        }

        if ($request->has('sort')) {
            $column = str_replace('-', '', $request->input('sort'));
            $direction = starts_with($request->input('sort'), '-') ? 'desc' : 'asc';
            if (Schema::hasColumn('journals', $column)) {
                $query = $query->orderBy($column, $direction);
            }
        }

        if ($request->has('page')) {
            $currentPage = $request->input('page');
            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
            $perPage = $request->has('per_page') ? $request->input('per_page') : 10;
            $query = $query->paginate($perPage);
        } else {
            $query = $query->get();
        }

        return response()->json($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'publish_date' => 'required|date|unique:journals,publish_date,NULL,id,user_id,' . $request->user()->id,
            'contents' => 'required',
            'events' => 'present',
        ]);

        $journal = new Journal;
        $journal->fill($request->only([
            'publish_date', 'contents', 'events',
        ]));
        $journal->user()->associate($request->user());
        $journal->save();

        return response()
            ->json($journal, 201)
            ->header('Location', route('journals.show', ['journal' => $journal]));
    }

    /**
     * Display the specified resource.
     *
     * @param   Illuminate\Http\Request  $request
     * @param   Journal  $journal
     *
     * @return  Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Journal $journal)
    {
        if ($request->has('embed')) {
            return response()->json($journal->load($request->input('embed')));
        }

        return response()->json($journal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   Illuminate\Http\Request  $request
     * @param   Journal  $journal
     *
     * @return  Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Journal $journal)
    {
        $this->validate($request, [
            'contents' => 'required',
            'events' => 'present',
        ]);

        $journal->update($request->only([
            'contents', 'events',
        ]));

        return response()->json($journal);
    }
}
