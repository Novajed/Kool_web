<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SongController extends Controller
{
    protected $grades = [
        'one'    => 1,
        'two'    => 2,
        'three'  => 3,
        'four'   => 4,
        'five'   => 5,
        'six'    => 6,
        'seven'  => 7,
        'eight'  => 8,
        'nine'   => 9,
        'ten'    => 10,
        'eleven' => 11,
        'twelve' => 12,
        'kinder' => 13,
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Song $songs){
        return response()->json($songs->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::guard('admin')->check()){
            $song = Song::create($request->except('file'));
            $this->attachGrades($request, $song);
            return response()->json(['message' => $song->title . ' has successfully been uploaded!'], 201);
        }
        return response()->json(null,404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        $song->incrementViews();
        return response()->json($song);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        //
    }

    public function browse(Grade $grade, $subject)
    {
        $songs = $grade->songs->where('subject_id', $subject);
        return response()->json($songs);
    }

    public function search(Request $request) {
        $query = $request->qry;
        
        $results = Song::where('title', 'like', '%'.$query.'%')
            ->orWhere('standard', 'like', '%'.$query.'%')
            ->orWhere('tags', 'like',  '%'.$query.'%')
            ->get();
        return $results;
    }

    public function query(Request $request)
    { 
        //set query variable
        $request->has('query')?
        $query = $request->all()['query']:
        $query = '';

        //set grades array
        $request->has('grades') ?
        $grades = array_unique(explode(',', $request->all()['grades'])):
        $grades =[];


        $validatedGrades = [];
        //validate the grades are greater than 0 and less than or equal to 13 remove if not
        foreach ($grades as $key => $grade) {
            if ($grade <= 13 && $grade > 0) {
                array_push($validatedGrades, $grade);
            }
        }

        //get all grades
        $grades = Grade::whereIn('id', $validatedGrades)->get();
        
        //initialize song collection not working currently initializing collection NOT WORKING TODO
        $songs = [];
        //for every grade get all the songs and merge theminto one collection.
        if($validatedGrades)
        foreach($validatedGrades as $grade) {
            $grade = Grade::find($grade);
            $currentSongs = $grade->songs->where('title', 'like', '%'.$query.'%')
            ->where('standard', 'like', '%'.$query.'%')
            ->where('tags', 'like',  '%'.$query.'%');
            $songs = $songs->merge($currentSongs);
            dd($currentSongs,'hit');
        }
        //remove all duplicates
        dd(array_unique($songs));
        
        //old code
        $results ='';

        return $results;
    }

    public function searchAndFilter() {

    }

    protected function subjectID($subject)
    {
        switch ($subject) {
            case 'ELA' || 'ela' || 'Ela':
                return 1;
                break;
            case 'Math' || 'math':
                return 2;
                break;
            case 'science' || 'Science':
                return 3;
                break;
            case 'Social-Studies' || 'social-studies':
                return 4;
                break;

        }
    }

    protected function attachGrades($request, Song $song)
    {
        foreach ($request->grades as $key => $grade) {
            $song->grades()->attach($this->grades[$key]);
        }
    }

    protected function storeRawSongData(Song $song)
    {
        if (Storage::exists('songs.txt')) {
            Storage::append('songs.txt', [$song, $song->grades()->pluck('grade_id')]);
        } else {
            Storage::put('songs.txt', [$song, $song->grades()->pluck('grade_id')]);
        }
    }

    protected function storeFile($request)
    {
        if ($request->hasFile('file')) {
            // Get filename with the extension

            $filenameWithExt = $request->file('file');

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('file')->getOriginalClientExtension();
            // Filename to store
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            //Upload Image
            $path = $request->file('file')->storeAs('storage/app/content/', $filenameToStore);
            dd($path);
        }
    }
}
