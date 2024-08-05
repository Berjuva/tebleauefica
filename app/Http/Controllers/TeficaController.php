<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeficaExport;

class TeficaController extends Controller
{
    public function index()
    {
        $table = $this->generateTable();
        return view('tefica', compact('table'));
    }

    public function generate(Request $request)
    {
        $table = $this->generateTable();
        return response()->json($table);
    }

    public function export(Request $request)
    {
        $table = $request->input('table');
        $export = new TeficaExport($table);
        $filename = 'tefica.xlsx';

        // Store the file temporarily
        Excel::store($export, $filename, 'local');

        // Return the file as a download response
        return response()->download(storage_path("app/{$filename}"))->deleteFileAfterSend(true);
    }

    public function emailForm()
    {
        return view('email');
    }

    public function sendEmail(Request $request)
    {
        $email = $request->input('email');
        $file = $request->file('file');

        Mail::send([], [], function ($message) use ($email, $file) {
            $message->to($email)
                ->subject('Tableau TEFICA')
                ->attach($file->getRealPath(), [
                    'as' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                ]);
        });

        return response()->json(['Mail envoyer avec succes' => true]);
    }

    private function generateTable()
    {
        $table = [];
        for ($i = 0; $i < 60; $i++) {
            $row = [];
            for ($j = 0; $j < 24; $j++) {
                $row[] = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);
            }
            $table[] = $row;
        }
        return $table;
    }
}
