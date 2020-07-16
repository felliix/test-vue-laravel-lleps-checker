<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function checkWord(Request $request)
    {
        $offsetDiff = $request->input('offsetDiff');
        $selectedWord = $request->input('selectedWord');
        $checkValue = $request->input('checkValue');

        $offset = levenshtein($selectedWord, $checkValue);
        $code = 0;
        $desc = [
            'Identical',
            'Loosely Matched',
            'No match'
        ];

        if ($offset === 0) {
            $code = 0;
        } else if ($offset <= $offsetDiff) {
            $code = 1;
        } else {
            $code = 2;
        }

        return response()->json([
            'code' => $code,
            'desc' => $desc[$code]
        ]);
    }
}
