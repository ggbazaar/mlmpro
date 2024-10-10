<?php

namespace App\Http\Controllers;

//
use App\User;
use App\Transaction;
use App\Train;
use App\AppAccount;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//
use Illuminate\Http\Request;

class HomeController extends Controller
{
      public function index()
      {
        $data['ddd'] = "asdfa asdfasdf";
        return view('home')->with($data);
      }


        public function showTree()
        {
            // Sample binary tree data
            $tree = [
                'value' => 'Root',
                'left' => [
                    'value' => 'Left Child 1',
                    'left' => [
                        'value' => 'Left Child 1.1',
                        'left' => null,
                        'right' => null,
                    ],
                    'right' => [
                        'value' => 'Left Child 1.2',
                        'left' => null,
                        'right' => null,
                    ],
                ],
                'right' => [
                    'value' => 'Right Child 2',
                    'left' => [
                        'value' => 'Right Child 2.1',
                        'left' => null,
                        'right' => null,
                    ],
                    'right' => [
                        'value' => 'Right Child 2.2',
                        'left' => null,
                        'right' => null,
                    ],
                ],
            ];

            return view('tree-view', compact('tree'));
        }
}
