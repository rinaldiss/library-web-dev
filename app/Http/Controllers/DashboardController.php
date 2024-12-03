<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Magazine;
use App\Models\Regulation;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::count();
        $magazines = Magazine::count();
        $regulations = Regulation::count();
        return view('pages.admin.dashboard', compact('books', 'magazines', 'regulations'));
    }


    public function sendMessage($phone, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env("WA_URL"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $phone,
                'message' => $message,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: '. env("WA_TOKEN")
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            echo $error_msg;
            die;
        }
    }
}
