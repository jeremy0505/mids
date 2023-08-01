<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



$index = -1;
$keysarr = array();
$valsarr = array();


class TextInController extends Controller
{

    //------------------------------------------------------------------------------------------------
    // TEXTIN



    function textin(Request $request)
    {

        global $index, $keysarr, $valsarr;
        $json_out = array();
        $labels = array();
        $values = array();
        $finarray = array();
        $finsub = 0;
        $sub = 0;

        $user = Auth::user();


        // Odd thing here - if I define the $elements outside and refer to it here 
        // via "global" I cannot actually use it in the later code - this is different behaviour compared to running 
        // the same code from within a php script at the command line.

        $elements = array('name'); // this could equally be a string - but using an array so that we can extend it later



        // take the text sent to us, log it, send it to oneai, log the response, return some structured data

        $text = $request->vtext;




        // log the text received



        // send it to oneai
        $time_start = microtime(true);

        // URL & api_key need to be externalised

        $url = 'https://api.oneai.com/api/v0/pipeline';
        $api_key = 'd777c079-8613-4aab-ada0-a4b1ef513b6e';

        $validatedData = '{
            "input": "[[TEXT]]",
            "steps": [
              {
                "skill": "names"},
        
                {"skill": "numbers"
              }       ]
        }';

        $validatedData = str_replace('[[TEXT]]', $text, $validatedData); // strip trailing newlines
        $validatedData = preg_replace('/[[:cntrl:]]/', ' ', $validatedData);  // replace all control characters 

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
        curl_setopt($curl, CURLOPT_POSTFIELDS, $validatedData);

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

                $finarray[$finsub] = array('org' => $org, 'date' => $date, 'money' => $money, 'duration' => $duration);
                $finsub++;
            }
        }

        $time_end = microtime(true);
        $execution_time = round(($time_end - $time_start), 2);
        $json_out['data_out'] = $finarray;
        $json_out['execution_time'] = $execution_time;
        $json_out['oneai_response'] = json_decode($oneairesp);


        // at this point we have a set of structured data that we can either return to the client
        // or process further ourselves - we want to create the relevant my_items records based on this
        // data - the assembly of the data into a json structure was an early development. We will
        // retain the json structure in case we want to reorgainse the code later. But we'll re-process the 
        // array data now to create records in my_items and then we will return a status message to the client.

        for ($i = 0; $i < $finsub; $i++) {
   

            $col_org = $finarray[$i]['org'];
            $col_date = $finarray[$i]['date'];
            $col_money = $finarray[$i]['money'];
            $col_duration = $finarray[$i]['duration'];

            if (str_contains(strtolower($col_duration),'month'))
              $col_duration = 'M';
            else
              $col_duration = 'Y';
              

            $sql_response = DB::insert("insert into my_items 
                        (item_type_id, 
                        user_id,
                        my_property_id, 
                        client_id, 
                        status, 
                        version, 
                        date_effective_from,
                        name,
                        mfr,
                        serial_number,
                        model_name, 
                        cost_initial, 
                        val_now, 
                        purch_date, 
                        start_date, 
                        expiry_date,
                        cost_recurring,
                        cost_recurring_freq,
                        colour, 
                        mileage, 
                        mot_date, 
                        sample_flag)
                        select it.item_type_id, 
                        '$user->id', 
                        mp.my_property_id,
                        0,
                        'ACTIVE',
                        1, 
                        curdate(),
                        '$col_org', 
                        null, 
                        '$col_org',
                        null,
                        null, 
                        null,
                        null,
                        null, 
                        null,
                        '$col_money', 
                        '$col_duration', 
                        null, 
                        null, 
                        null, 
                        'N'
                        from item_types it, 
                             my_properties mp
                        where it.code='VIDEO_STREAM'
                        and  mp.user_id = '$user->id'
                        and not exists (select 0
                                        from   my_items mi2
                                        where  mi2.user_id = '$user->id'
                                        and    mi2.mfr = '$col_org')");  
        //   echo 'main $sql_response=' . $sql_response . PHP_EOL;

        //   $sql_response = DB::raw("select count(*) cnt f
        //                               from   my_items mi2
        //   where  mi2.user_id = '$user->id'
        //   and    mi2.mfr = '$col_org'");

     
                     
        }

        
        return ['status' => 'OK', 'message' => 'Item records created OK'];

        // return [($json_out), 200];
    }
}


//------------------------------------------------------------------------------------------------
// OUTPUTRECURSIVE

function outputRecursive($validatedData)
{
    global $i;
    global $index;
    global $keysarr;
    global $valsarr;


    foreach ($validatedData as $key => $value) {


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

                continue;
            }

            $index = $index + 1;

            $keysarr[$index] = $key;
            $valsarr[$index] = $value;



            // }
        }
    }
}


//------------------------------------------------------------------------------------------------
// FINDNEXT

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
