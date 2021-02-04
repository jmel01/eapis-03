<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    function myDocument()
    {
        $documents = Document::where('user_id', Auth::id())->get();

        return view('documents.mydocument', compact('documents'));
    }

    public function myDocumentStore(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|max:2048',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //=> required|file|max:5000|mimes:pdf,docx,doc
        ]);

        $image = $request->file('image');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $new_name);
        $form_data = array(
            'user_id' => Auth::id(),
            'filename' => $image->getClientOriginalName(),
            'filepath' => $new_name
        );

        Document::create($form_data);

        return back()
            ->with('success', 'Document created successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'grantID',
            'requirementID' => 'required',
            'image' => 'required|max:2048',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //=> required|file|max:5000|mimes:pdf,docx,doc
            'schoolYear'
        ]);

        $image = $request->file('image');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $new_name);
        $form_data = array(
            'grantID' => $request->grantID,
            'user_id' => Auth::id(),
            'filename' => $image->getClientOriginalName(),
            'filepath' => $new_name,
            'requirementID' => $request->requirementID
            
        );

        Document::create($form_data);

        return back()
            ->with('success', 'Document created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($id) //Show Student Document on Student Application
    {
        $documents = Document::with('grantDetails')
            ->with('requirementDetails')
            ->where('grantID', $id)
            ->where('user_id', Auth::id())
            ->get();

        return view('documents.show', compact('documents'));
    }

    public function showAttachment($grantID,$userID) //Show Attached Document on Grant List
    {
        $documents = Document::where('grantID', $grantID)
            ->where('user_id', $userID)
            ->get();

        return view('documents.show', compact('documents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Document::find($id)->delete();

        $notification = array(
            'message' => 'Document Deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
