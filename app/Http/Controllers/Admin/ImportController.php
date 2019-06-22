<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\PetugasImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AnggotaImport;

class ImportController extends Controller
{
    public function index($table)
    {
        switch ($table) {
            case 'anggota':
                return $this->importAnggota();
            break;
            
            case 'petugas':
                return $this->importPetugas();
            break;
            
            default:
                abort(404);    
            break;
        }
    }

    private function importAnggota()
    {
        $request = request();
        $validator = \Validator::make($request->all(), [
            'anggota_excel' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails())
        {
            $response = [
                'status' => false,
                'msg' => 'form error',
                'errors' => $validator->errors()->first('anggota_excel')
            ];

            return response()->json($response);
        }
        
        $anggotaExcel = $request->file('anggota_excel');
        try {
            Excel::import(new AnggotaImport, $anggotaExcel);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errors = [];
             foreach ($failures as $key => $failure) {
                $errors[$key]['row'] = $failure->row(); 
                $errors[$key]['attribute'] = $failure->attribute(); 
                $errors[$key]['errors'] = $failure->errors(); 
                $errors[$key]['values'] = $failure->values();
            }
             $response = [
                'status' => false,
                'msg' => 'format error',
                'errors' => $errors,
            ];

            return response()->json($response);
        }

        $response = [
            'status' => true,
            'msg' => 'Data berhasil dimport',
            'data' => '',
        ];
        return response()->json($response);
    }

    public function importPetugas() 
    {
        $request = request();
        $validator = \Validator::make($request->all(), [
            'petugas_excel' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails())
        {
            $response = [
                'status' => false,
                'msg' => 'form error',
                'errors' => $validator->errors()->first('petugas_excel')
            ];

            return response()->json($response);
        }
        
        $petugasExcel = $request->file('petugas_excel');
        try {
            Excel::import(new PetugasImport, $petugasExcel);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errors = [];
             foreach ($failures as $key => $failure) {
                $errors[$key]['row'] = $failure->row(); 
                $errors[$key]['attribute'] = $failure->attribute(); 
                $errors[$key]['errors'] = $failure->errors(); 
                $errors[$key]['values'] = $failure->values();
            }
             $response = [
                'status' => false,
                'msg' => 'format error',
                'errors' => $errors,
            ];

            return response()->json($response);
        }

        $response = [
            'status' => true,
            'data' => '',
        ];

        return response()->json($response);
    }
}
