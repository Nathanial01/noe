<?php

 namespace App\Nova\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return response()->download(storage_path($request['file']))->deleteFileAfterSend(true);
    }
}
