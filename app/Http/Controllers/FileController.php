<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'filenames' => 'required',
                'filenames.*' => 'required'
        ]);

        $files = [];
        if($request->hasfile('filenames'))
         {
            foreach($request->file('filenames') as $file)
            {
                $imageName = time().rand(1,100).'.'.$file->extension();
              //  $file->move(public_path('files'), $imageName);
                $file->storeAs('files', $imageName);
                $files[] = $imageName;

                // $file->storeAs('files', $imageName);  *Store File in Storage Folder  *storage/app/files/file.png
                // $file->move(public_path('files'), $imageName);  *Store File in Public Folder *public/files/file.png
                // $file->storeAs('files', $imageName, 's3');  *Store File in S3

            }
         }

         $file= new File();
         $file->filenames = $files;
         $file->save();

        return back()->with('success', 'Data Your files has been successfully added');
    }
}
