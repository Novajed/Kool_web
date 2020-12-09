<?php 

namespace App\Repository;

use App\Grade;

class Search 
{
	public function query($qry) 
	{
		
		$results = Song::where('title', 'like', '%'.$query.'%')
            ->orWhere('standard', 'like', '%'.$query.'%')
            ->orWhere('tags', 'like',  '%'.$query.'%')
            ->get();

	}
}