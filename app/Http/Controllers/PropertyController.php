<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function getProperties()
    {
        //$properties = Property::all();
        $properties = Property::where('status', '!=', 'Closed')->orderBy('status', 'asc')->orderBy('updated_at', 'desc')->paginate(12);

        $response = [
            'code' => 200,
            'data' => $properties
        ];

        return response()->json($response, 200);
    }

    public function getProperty($id)
    {
        //$properties = Property::all();
        $property = Property::find($id);

        $response = [
            'code' => 200,
            'data' => $property
        ];

        return response()->json($response, 200);
    }

    public function getPropertiesHome($type)
    {
        //$properties = Property::all();
        $properties = Property::select('id', 'list_number', 'street', 'city', 'bedrooms', 'baths_full', 'baths_mid', 'sq_total', 'price', 'picture_count','image', 'listing_office_name', 'colisting_office_name', 'listing_member_shortid', 'colisting_member_shortid' )->where('type','=', $type)->where('status', '!=', 'Closed')->inRandomOrder()->take(4)->get();

        $response = [
            'code' => 200,
            'data' => $properties
        ];

        return response()->json($response, 200);
    }

    public function propertiesByType($type)
    {
        $properties = Property::where('type', '=', $type)->where('status', '!=', 'Closed')->orderBy('status', 'asc')->orderBy('updated_at', 'desc')->paginate(12);

        $response = [
            'code' => 200,
            'data' => $properties
        ];

        return response()->json($response, 200);
    }

    public function getPropertiesByQuery($feature, $query)
    {
        $properties = Property::where($feature, '=', $query)->where('status', '!=', 'Closed')->orderBy('status', 'asc')->orderBy('updated_at', 'desc')->paginate(12);

        $response = [
            'code' => 200,
            'data' => $properties
        ];

        return response()->json($response, 200);
    }

    public function getDataByColumn()
    {
        $properties = Property::all();

        $dataFields = [
            'city' => $properties->pluck('city')->unique()->values()->toArray(),
            'county' => $properties->pluck('county')->unique()->values()->toArray(),
            'state' => $properties->pluck('state')->unique()->values()->toArray(),
            'elementary_school' => $properties->pluck('elementary_school')->unique()->values()->toArray(),
            'middle_school' => $properties->pluck('middle_school')->unique()->values()->toArray(),
            'high_school' => $properties->pluck('high_school')->unique()->values()->toArray(),
            'zipcode' => $properties->pluck('zipcode')->unique()->values()->toArray(),
            'subtype' => $properties->pluck('subtype')->unique()->values()->toArray(),
        ];

        $response = [
            'code' => 200,
            'data' => $dataFields
        ];


        return response()->json($response, 200);
    }

    public function getCountsResults(){
        $countyCounts =  Property::select('county as name', DB::raw('count(*) as count'))
        ->groupBy('county')
        ->orderBy('count', 'desc')
        ->take(10)
        ->get();

        $response = [
            'code' => 200,
            'countyCounts' => $countyCounts
        ];

        return response()->json($response, 200);
    }

    public function sendMail(Request $request){

        $validated = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
            'typetour' => 'required',
            'date' => 'required',
            'time' => 'required',
            'propertyid' => 'required'
        ]);

        if($validated->fails()){
            return response()->json([
                'errors' => $validated->errors()->first()
            ], 422);
        }


        $property = Property::find($request->propertyid);

        $mailContact = new ContactMessage($validated->validated(), $property);

        $mailSended = Mail::to('dbliones@gmail.com')->cc('bynethz@gmail.com')->send($mailContact);
        //$mailSended = Mail::to('bynethz@gmail.com')->send($mailContact);

        if(!$mailSended){
            $data = [
                'code' => 400,
                'message' => 'Failure sending email'
            ];
        }

        $data = [
            'code' => 200,
            'message' => 'Email sent successfully'
        ];

        return response()->json($data, $data['code']);
    }
}
