<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


$index = -1;
$keysarr = array();
$valsarr = array();


//$elements = array ('name'); // this could equally be a string - but using an array so that we can extend it later



class AuthController extends Controller
{

    //------------------------------------------------------------------------------------------------
    // REGISTER


    public function register(Request $request)
    {

        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // creates the user record in the database 
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // can also use bcrypt - but same underlying code is executed
        ]);

        // generate the access token
        $token = $user->createToken('auth_token')->plainTextToken; // the name 'auth_token' appears to be insignificant 
        //- same behaviour when I called it 'fred'

        // send the access token back in JSON format
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201); // why send back a 201 response
    }




    //------------------------------------------------------------------------------------------------
    // LOGIN



    public function login(Request $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        // As I understand it, this is returning the first user whose email address matches that passed in - so operates on the assumption 
        // that the same email address may not be used for multiple users (obvious - but wanting to make sure)

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    //------------------------------------------------------------------------------------------------
    // LOGOFF


    public function logoff(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'user logged out'
        ];
    }



    //------------------------------------------------------------------------------------------------
    // ME



    public function me(Request $request)
    {
        return $request->user();
    }


    //------------------------------------------------------------------------------------------------
    // TEXTIN



    public function textin(Request $request)
    {

        global $index, $keysarr, $valsarr;
        $json_out = array();
        $labels = array();
        $values = array();
        $finarray = array();
        $finsub = 0;
        $sub = 0;

        // Odd thing here - if I define the $elements outside and refer to it here 
        // via "global" I cannot actually use it in the later code - this is different behaviour compared to running 
        // the same code from within a php script at the command line.

        $elements = array('name'); // this could equally be a string - but using an array so that we can extend it later



        // take the text sent to us, log it, send it to oneai, log the response, return some structured data

        $text = $request->vtext;




        // log the text received



        // send it to oneai
        $time_start = microtime(true);
        $url = 'https://api.oneai.com/api/v0/pipeline';

        $api_key = 'd777c079-8613-4aab-ada0-a4b1ef513b6e';

        $data = '{
            "input": "[[TEXT]]",
            "steps": [
              {
                "skill": "names"},
        
                {"skill": "numbers"
              }       ]
        }';

        $data = str_replace('[[TEXT]]', $text, $data); // strip trailing newlines
        $data = preg_replace('/[[:cntrl:]]/', ' ', $data);  // replace all control characters 

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
            "api-key: $api_key",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $oneairesp = curl_exec($curl);
        curl_close($curl);


        // Ok so the variable $oneairesp is what was returned from the https call


        //echo '$oneairesp=' . $oneairesp;
        if ($decoded = json_decode($oneairesp, true)) {

            $index = -1;

            // echo 'json_decode cond was TRUE' . PHP_EOL;

            // echo 'hello index value (pre-call) =' . $index . PHP_EOL; // issue here is this = -1 still... 

            outputRecursive($decoded);

            // echo 'index value (post-call) =' . $index . PHP_EOL; // issue here is this = -1 still... 


            for ($inc = 0; $inc <= $index; $inc++) {


                $keycomp = strtolower($keysarr[$inc]);

                // look for the elements we are interested in - in this example in fact it's just 'name'

                if (in_array($keycomp, $elements)) {

                    // then we know this will be followed by a value in the array so....

                    //echo ' ' . $valsarr[$inc] . ':' . $valsarr[$inc + 1] . PHP_EOL;


                    // stick the values into an array - we want label & value
                    $labels[$sub] = strtolower($valsarr[$inc]);
                    $values[$sub] = $valsarr[$inc + 1];
                    $sub = $sub + 1;
                }
            }

            /*
            so we have a clear array of effectively name/value pairs - we actually want to process 
            the 'org' elements - these represent the start of a "record" for us

                    I want to produce a repeating structure
                      - org:
                      - date:
                      - money:
                      - duration:


            */


            $loops = count($labels);

            for ($i = 0; $i < $loops; $i++) {


                if ($labels[$i] != 'org')
                    continue;

                // each org label represents the start of a new "record" in our json
                $org = $values[$i];
                $date = findnext($labels, $values, 'date', $i);
                $money = findnext($labels, $values, 'money', $i);
                $duration = findnext($labels, $values, 'duration', $i);

                // echo 'our record looks thus:' . PHP_EOL;
                // echo ' - org:' . $org . PHP_EOL;
                // echo ' - date:' . $date . PHP_EOL;
                // echo ' - money:' . $money . PHP_EOL;
                // echo ' - duration:' . $duration . PHP_EOL;

                $finarray[$finsub] = array('org' => $org, 'date' => $date, 'money' => $money, 'duration' => $duration);
                $finsub++;
            }
        }



        // for ($i = 0; $i < $sub; $i++) {

        //     // to build a single "record" in json we need to specify on a single line like the example below - 
        //     // but that means I need to collect all of the values (and add any missing) 
        //     if ($labels[$i] = 'org') {
        //         // is next value also "org" - if so we should create a dummy entry for date
        //         null;
        //     }
        // }

        $time_end = microtime(true);
        $execution_time = round(($time_end - $time_start), 2);
        $json_out['data_out'] = $finarray;
        $json_out['execution_time'] = $execution_time;
        $json_out['oneai_response'] = json_decode($oneairesp);





        // what we want to do here is to construct a JSON structure returning the 
        // relevant data items we have received from oneAI - this data all now exists in arrays - 
        // but is muddled - let's assume that the structure of data is one or more 
        // "organisations" but just take the first occurrence of date, money, duration - we're assuming 
        // in these examples that the period and price are the same for all organisations

        // so we have the arrays - $labels & $values - and we have the elapsed_time
        // how do we construct a json object from this?




        // for ($j = 0; $j < $i; $j++) {

        //     $json_out[$labels[$j]] = $values[$j];

        // }
        // echo 'Elapsed ' . $execution_time . ' ms' . PHP_EOL;



        return [($json_out), 200];
    }
}





function outputRecursive($data)
{
    global $i;
    global $index;
    global $keysarr;
    global $valsarr;


    foreach ($data as $key => $value) {


        $i = $i + 1;

        if (is_array($value)) {
            if (!is_int($key)) {
                // no need to do anything here really
                // echo 'A - outputRecursive ' . $index . PHP_EOL;
                null;
            }

            // echo 'call to self...' . PHP_EOL;

            outputRecursive($value); // call to this same function

        } else {
            if (is_int($key)) {
                null;
                // echo "The key is an INT $value" . PHP_EOL;
                // echo 'B - outputRecursive ' . $index . PHP_EOL;

                continue;
            }
            // if ($key=='name') {

            //echo $key . '::' . $value . PHP_EOL;
            // echo 'C - outputRecursive ' . $index . PHP_EOL;

            $index = $index + 1;
            // echo '$key=' . $key . PHP_EOL;
            // echo '$value=' . $value . PHP_EOL;
            $keysarr[$index] = $key;
            $valsarr[$index] = $value;



            // }
        }
    }
}


function findnext($labels, $values, $what, $index)
{

    // locate in the array the next instance of the requested item


    for ($i2 = $index; $i2 < count($labels); $i2++) {


        if (strtolower($labels[$i2]) == $what) {
            return ($values[$i2]);
        }
    }

    return null;
}
