<?php

namespace App\Http\Controllers;

use App\Models\AuditEvent;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
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
            'requirementID',
            'image' => 'required|max:2048',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'schoolYear'
        ]);

        $image = $request->file('image');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $new_name);
        $form_data = array(
            'grantID' => $request->grantID,
            'user_id' => Auth::id(),
            'filename' => $new_name,
            'schoolYear' => '2021',
            'requirementID' => $request->requirementID,
            'filepath' => 'afgasgasga'
        );

        Document::create($form_data);

        AuditEvent::insert('Create document');

        return back()
            ->with('success', 'Document created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $documents = Document::with('grantDetails')
            ->with('requirementDetails')
            ->where('user_id', Auth::id())
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
    public function destroy(Document $document)
    {
        //
    }
}
