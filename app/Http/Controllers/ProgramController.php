<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of programs.
     */
    public function index()
    {
        $programs = Program::all();
        return view('public.program.index', compact('programs'));
    }

    /**
     * Display the specified program.
     */
    public function show($code)
    {
        $program = Program::where('code', $code)->firstOrFail();
        $otherPrograms = Program::where('id', '!=', $program->id)->limit(4)->get();
        $relatedStories = \App\Models\Story::where('program_id', $program->id)->latest()->get();
        return view('public.program.show', compact('program', 'otherPrograms', 'relatedStories'));
    }
}
