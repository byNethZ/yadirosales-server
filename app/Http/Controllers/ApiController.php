<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public $config;
    public $rets;
    public $existingId;

    public $hashtable = array(
        "a" => array(
            "Active" => array(
                "code" => "181H8FBIFTPE",
                "limit" => 3000
            ),
            "Pending" => array(
                "code" => "181H8FBIFF23",
                "limit" => 1000
            ),
            "Contingent" => array(
                "code" => "PWC_1AIXYK1RX78Y",
                "limit" => 1000
            )
        ),
        "b" => array(
            "Active" => array(
                "code" => "182D5OCX522O",
                "limit" => 3000
            ),
            "Pending" => array(
                "code" => "182D5OCX4NBN",
                "limit" => 1000
            ),
            "Contingent" => array(
                "code" => "PWC_1AIXYK1YZ8KG",
                "limit" => 1000
            )
        ),
        "c" => array(
            "Active" => array(
                "code" => "183A3XUPR91U",
                "limit" => 3000
            ),
            "Pending" => array(
                "code" => "183A3XUPRM4Z",
                "limit" => 1000
            ),
            "Contingent" => array(
                "code" => "PWC_1AIXYK1Z1ILC",
                "limit" => 1000
            )
        ),
        "d" => array(
            "Active" => array(
                "code" => "1DAKHJPJ3HIK",
                "limit" => 3000
            ),
            "Pending" => array(
                "code" => "1DAKHJPJ2YWK",
                "limit" => 1000
            ),
            "Contingent" => array(
                "code" => "PWC_1DAKHJPFKBD2",
                "limit" => 1000
            )
        ),
    );

    public function __construct()
    {
        //Config PHRets
        $this->config = new  \PHRETS\Configuration;
        $this->config->setLoginUrl('http://retsgw.flexmls.com/rets2_3/Login')
            ->setUsername('gcar.rets.Bliones')
            ->setPassword('vG(1n57vOw')
            ->setRetsVersion('1.7.2');
        $this->rets = new \PHRETS\Session($this->config);
    }

    public function activeAgents()
    {
        $connect = $this->rets->Login();

        $activeAgentsData = $this->rets->Search('ActiveAgent', 'Agent', '*', ['Limit' => 10]);
        $response = ['data' => $activeAgentsData->toArray()];

        return response()->json($response, 200);
    }

    public function agents()
    {
        $connect = $this->rets->Login();

        $agentsData = $this->rets->Search('Agent', 'Agent', '*', ['Limit' => 10]);
        $response = ['data' => $agentsData->toArray()];

        return response()->json($response, 200);
    }

    public function offices()
    {
        $connect = $this->rets->Login();

        $officeData = $this->rets->Search('Office', 'Office', '*', ['Limit' => 10]);
        $response = ['data' => $officeData->toArray()];

        return response()->json($response, 200);
    }

    public function units()
    {
        $connect = $this->rets->Login();

        $unitData = $this->rets->Search('Unit', 'B', '*', ['Limit' => 10]);
        $response = ['data' => $unitData->toArray()];

        return response()->json($response, 200);
    }

    public function rooms()
    {
        $connect = $this->rets->Login();

        $roomData = $this->rets->Search('Room', 'A', '*', ['Limit' => 10]);
        $response = ['data' => $roomData->toArray()];

        return response()->json($response, 200);
    }

    public function openhouses()
    {
        $connect = $this->rets->Login();

        $openHouseData = $this->rets->Search('OpenHouse', 'OpenHouse', '*', ['Limit' => 10]);
        $response = ['data' => $openHouseData->toArray()];

        return response()->json($response, 200);
    }

    public function propertiesStore($type, $status)
    {
        $typeQuery = strtoupper($type);

        $connect = $this->rets->Login();

        $DMQL2Query = '(LIST_15=|' . $this->hashtable[$type][$status]['code'] . ')';

        $PropertyData = $this->rets->Search('Property', $typeQuery, $DMQL2Query, ['Limit' => $this->hashtable[$type][$status]['limit'], 'QueryType' => 'DMQL2',]);

        $dataFormatted = $this->saveData($PropertyData->toArray());
        //$response = ['data' => $dataFormatted];
        $response = ['data' => $PropertyData->toArray(), 'existingID' => $this->existingId];

        return response()->json($response, 200);
    }

    public function properties($type, $status)
    {
        $typeQuery = strtoupper($type);
        $connect = $this->rets->Login();

        $DMQL2Query = '(LIST_15=|' . $this->hashtable[$type][$status]['code'] . ')';

        $PropertyData = $this->rets->Search('Property', $typeQuery, $DMQL2Query, ['Limit' => $this->hashtable[$type][$status]['limit'], 'QueryType' => 'DMQL2',]);

        //$dataFormatted = $this->saveData($PropertyData->toArray());
        //$response = ['data' => $dataFormatted];
        $response = ['data' => $PropertyData->toArray()];

        return response()->json($response, 200);
    }

    public function images($id)
    {
        $connect = $this->rets->Login();

        $imagesData = $this->rets->GetObject('Property', 'HiRes', $id, '*', 1);
        $id_search = [];
        foreach ($imagesData as $key => $images) {
            $value = $imagesData[$key]->getLocation();
            $id_search[] = $value;
        }

        $response = ['imagesUrl' => $id_search];

        return response()->json($response, 200);
    }

    public function image($id)
    {

        $connect = $this->rets->Login();


        $imagesData = $this->rets->GetObject('Property', 'Photo', $id, '*', 1);
        //$imageData = $imagesData->first();

        foreach ($imagesData as $imageSingle) {
            if ($imageSingle->isPreferred()) {
                $imageData = $imageSingle;
            }
        }

        if (!isset($imageData)) {
            $imageData = $imagesData->first();
        }

        $url = $imageData->getLocation();

        $response = ['imageUrl' => $url];

        //return response()->json($response, 200);
        return $url;
    }

    public function cleanTable() {
        // Obtener los registros que no han sido actualizados en un mes
        $properties = Property::where('updated_at', '<', Carbon::now()->subMonth())
           // Solo obtener los registros con el estado "Closed"
           ->where('status', 'Closed')
           ->get();

        // Recorrer los registros y eliminarlos
        foreach ($properties as $property) {
           $property->delete();
        }
    }

    private function getIds()
    {
        $ids = [];

        $idsQuery = Property::all('list_number')->toArray();

        foreach ($idsQuery as $row) {
            array_push($ids, $row['list_number']);
        }

        return $ids;
    }

    private function saveData($data)
    {
        $dataOrganized = [];
        $this->existingId = $this->getIds();

        foreach ($data as $property) {
            //$result = array_search($property['LIST_3'], $this->existingId);
            $propertySaved = Property::firstWhere('list_number', $property['LIST_3']);

            if ($propertySaved) {

                if($propertySaved->status && $property['LIST_15'] && $propertySaved->status != $property['LIST_15']){

                    $propertySaved->update([
                        'status' => $property['LIST_15']
                    ]);

                }

            } else {

                $propertySave = new Property;

                $propertySave->fill([
                    'list_number' => isset($property['LIST_3']) ? $property['LIST_3'] : null,
                    'approved' => isset($property['LIST_4']) ? $property['LIST_4'] : null,
                    'type' => isset($property['LIST_8']) ? $property['LIST_8'] : null,
                    'timestamp' => isset($property['LIST_87']) ? $property['LIST_87'] : null,
                    'public' => isset($property['LIST_104']) ? $property['LIST_104'] : null,
                    'modify_timestamp' => isset($property['LIST_132']) ? $property['LIST_132'] : null,
                    'picture_count' => isset($property['LIST_133']) ? $property['LIST_133'] : null,
                    'subtype' => isset($property['LIST_9']) ? $property['LIST_9'] : null,
                    'status' => isset($property['LIST_15']) ? $property['LIST_15'] : null,
                    'price' => isset($property['LIST_22']) ? $property['LIST_22'] : null,
                    'street_number' => isset($property['LIST_31']) ? $property['LIST_31'] : null,
                    'street' => isset($property['LIST_34']) ? $property['LIST_34'] : null,
                    'street_suffix' => isset($property['LIST_37']) ? $property['LIST_37'] : null,
                    'city' => isset($property['LIST_39']) ? $property['LIST_39'] : null,
                    'state' => isset($property['LIST_40']) ? $property['LIST_40'] : null,
                    'county' => isset($property['LIST_41']) ? $property['LIST_41'] : null,
                    'zipcode' => isset($property['LIST_43']) ? $property['LIST_43'] : null,
                    'latitude' => isset($property['LIST_46']) ? $property['LIST_46'] : null,
                    'longitude' => isset($property['LIST_47']) ? $property['LIST_47'] : null,
                    'sq_total' => isset($property['LIST_48']) ? $property['LIST_48'] : null,
                    'year_built' => isset($property['LIST_53']) ? $property['LIST_53'] : null,
                    'lot_size' => isset($property['LIST_56']) ? $property['LIST_56'] : null,
                    'acres' => isset($property['LIST_57']) ? $property['LIST_57'] : null,
                    'rooms' => isset($property['LIST_65']) ? $property['LIST_65'] : null,
                    'bedrooms' => isset($property['LIST_66']) ? $property['LIST_66'] : null,
                    'baths' => isset($property['LIST_67']) ? $property['LIST_67'] : null,
                    'baths_full' => isset($property['LIST_68']) ? $property['LIST_68'] : null,
                    'baths_mid' => isset($property['LIST_69']) ? $property['LIST_69'] : null,
                    'taxes' => isset($property['LIST_75']) ? $property['LIST_75'] : null,
                    'subdivision' => isset($property['LIST_77']) ? $property['LIST_77'] : null,
                    'taxmap' => isset($property['LIST_80']) ? $property['LIST_80'] : null,
                    'legal_desc' => isset($property['LIST_81']) ? $property['LIST_81'] : null,
                    'deed_page' => isset($property['LIST_91']) ? $property['LIST_91'] : null,
                    'deed_book' => isset($property['LIST_92']) ? $property['LIST_92'] : null,
                    'elementary_school' => isset($property['LIST_93']) ? $property['LIST_93'] : null,
                    'middle_school' => isset($property['LIST_94']) ? $property['LIST_94'] : null,
                    'high_school' => isset($property['LIST_95']) ? $property['LIST_95'] : null,
                    'hoa_fee' => isset($property['LIST_114']) ? $property['LIST_114'] : null,
                    'directions' => isset($property['LIST_141']) ? $property['LIST_141'] : null,
                    'auction' => isset($property['LIST_149']) ? $property['LIST_149'] : null,
                    'home_warranty' => isset($property['LIST_151']) ? $property['LIST_151'] : null,
                    'builders_warranty' => isset($property['LIST_152']) ? $property['LIST_152'] : null,
                    'public_remarks' => isset($property['LIST_231']) ? $property['LIST_231'] : null,
                    'monthly_rent' => isset($property['LIST_119']) ? $property['LIST_119'] : null,
                    'units' => isset($property['LIST_120']) ? $property['LIST_120'] : null,
                    'fireplace_list' => isset($property['LIST_117']) ? $property['LIST_117'] : null,
                    'pets_allowed' => isset($property['LIST_192']) ? $property['LIST_192'] : null,
                    'gf_new_construction' => isset($property['GF20220104022925902591000000']) ? $property['GF20220104022925902591000000'] : null,
                    'style' => isset($property['GF20180123134656859287000000']) ? $property['GF20180123134656859287000000'] : null,
                    'existing_financing' => isset($property['GF20141111203904975371000000']) ? $property['GF20141111203904975371000000'] : null,
                    'unit_one_features' => isset($property['GF20141111182425714915000000']) ? $property['GF20141111182425714915000000'] : null,
                    'unit_two_features' => isset($property['GF20141111182436214109000000']) ? $property['GF20141111182436214109000000'] : null,
                    'unit_three_features' => isset($property['GF20141111182448209798000000']) ? $property['GF20141111182448209798000000'] : null,
                    'unit_four_features' => isset($property['GF20141111182500937994000000']) ? $property['GF20141111182500937994000000'] : null,
                    'clear_percent' => isset($property['GF20141205150401515543000000']) ? $property['GF20141205150401515543000000'] : null,
                    'adjacent_use' => isset($property['GF20141205150644103916000000']) ? $property['GF20141205150644103916000000'] : null,
                    'docs_file' => isset($property['GF20141205150435473340000000']) ? $property['GF20141205150435473340000000'] : null,
                    'flood_zone' => isset($property['GF20141205150953755076000000']) ? $property['GF20141205150953755076000000'] : null,
                    'improvements' => isset($property['GF20141205150334445880000000']) ? $property['GF20141205150334445880000000'] : null,
                    'options' => isset($property['GF20141205150453735921000000']) ? $property['GF20141205150453735921000000'] : null,
                    'road' => isset($property['GF20141205150215701361000000']) ? $property['GF20141205150215701361000000'] : null,
                    'shape' => isset($property['GF20141205150203596817000000']) ? $property['GF20141205150203596817000000'] : null,
                    'structures' => isset($property['GF20141205150536610107000000']) ? $property['GF20141205150536610107000000'] : null,
                    'listing_member_shortid' => isset($property['listing_member_shortid']) ? $property['listing_member_shortid'] : null,
                    'colisting_member_shortid' => isset($property['colisting_member_shortid']) ? $property['colisting_member_shortid'] : null,
                    'selling_member_shortid' => isset($property['selling_member_shortid']) ? $property['selling_member_shortid'] : null,
                    'coselling_member_shortid' => isset($property['coselling_member_shortid']) ? $property['coselling_member_shortid'] : null,
                    'listing_member_name' => isset($property['listing_member_name']) ? $property['listing_member_name'] : null,
                    'colisting_member_name' => isset($property['colisting_member_name']) ? $property['colisting_member_name'] : null,
                    'selling_member_name' => isset($property['selling_member_name']) ? $property['selling_member_name'] : null,
                    'coselling_member_name' => isset($property['coselling_member_name']) ? $property['coselling_member_name'] : null,
                    'listing_office_name' => isset($property['listing_office_name']) ? $property['listing_office_name'] : null,
                    'selling_office_name' => isset($property['selling_office_name']) ? $property['selling_office_name'] : null,
                    'colisting_office_name' => isset($property['colisting_office_name']) ? $property['colisting_office_name'] : null,
                    'coselling_office_name' => isset($property['coselling_office_name']) ? $property['coselling_office_name'] : null,
                    'image' => isset($property['LIST_3']) ? $this->image($property['LIST_3']) : null
                ]);

                switch ($property['LIST_8']) {
                    case 'A':
                        $propertySave->fill([
                            'garage_parking' => isset($property['FEAT20180123143511417736000000']) ? $property['FEAT20180123143511417736000000'] : null,
                            'owner' => isset($property['FEAT20180122210900608311000000']) ? $property['FEAT20180122210900608311000000'] : null,
                            'gf_appliances' => isset($property['GF20141105190528845508000000']) ? $property['GF20141105190528845508000000'] : null,
                            'basement' => isset($property['GF20141105190907544571000000']) ? $property['GF20141105190907544571000000'] : null,
                            'bed_bath' => isset($property['GF20141105190355983445000000']) ? $property['GF20141105190355983445000000'] : null,
                            'brick_stone' => isset($property['GF20191112201228797891000000']) ? $property['GF20191112201228797891000000'] : null,
                            'gf_community_features' => isset($property['GF20141105190714124248000000']) ? $property['GF20141105190714124248000000'] : null,
                            'cooling' => isset($property['GF20141105190341847555000000']) ? $property['GF20141105190341847555000000'] : null,
                            'description' => isset($property['GF20141105190204376686000000']) ? $property['GF20141105190204376686000000'] : null,
                            'dining' => isset($property['GF20141105190553212029000000']) ? $property['GF20141105190553212029000000'] : null,
                            'documents' => isset($property['GF20150209174212866445000000']) ? $property['GF20150209174212866445000000'] : null,
                            'gf_equipment' => isset($property['GF20141105190656459299000000']) ? $property['GF20141105190656459299000000'] : null,
                            'gf_exterior' => isset($property['GF20141105190247060619000000']) ? $property['GF20141105190247060619000000'] : null,
                            'exterior_features' => isset($property['GF20141105190325982321000000']) ? $property['GF20141105190325982321000000'] : null,
                            'financing_available' => isset($property['GF20141105190804289906000000']) ? $property['GF20141105190804289906000000'] : null,
                            'gf_fireplace' => isset($property['GF20141105190749018131000000']) ? $property['GF20141105190749018131000000'] : null,
                            'floors' => isset($property['GF20141205192125962774000000']) ? $property['GF20141205192125962774000000'] : null,
                            'gf_foundation' => isset($property['GF20141205195649976969000000']) ? $property['GF20141205195649976969000000'] : null,
                            'gf_furnished' => isset($property['GF20141105190456975417000000']) ? $property['GF20141105190456975417000000'] : null,
                            'gf_garage' => isset($property['GF20141105190217075291000000']) ? $property['GF20141105190217075291000000'] : null,
                            'gf_green_features' => isset($property['GF20141105190640048601000000']) ? $property['GF20141105190640048601000000'] : null,
                            'heating' => isset($property['GF20141105190515312181000000']) ? $property['GF20141105190515312181000000'] : null,
                            'interior' => isset($property['GF20141105190231914421000000']) ? $property['GF20141105190231914421000000'] : null,
                            'lease_terms' => isset($property['GF20141105190425245624000000']) ? $property['GF20141105190425245624000000'] : null,
                            'gf_lot_description' => isset($property['GF20141105190608614137000000']) ? $property['GF20141105190608614137000000'] : null,
                            'gf_new_construction' => isset($property['GF20220104022925902591000000']) ? $property['GF20220104022925902591000000'] : null,
                            'owner_pays' => isset($property['GF20141105190818994827000000']) ? $property['GF20141105190818994827000000'] : null,
                            'pool' => isset($property['GF20141205192215207835000000']) ? $property['GF20141205192215207835000000'] : null,
                            'possession' => isset($property['GF20141105190625140178000000']) ? $property['GF20141105190625140178000000'] : null,
                            'roofing' => isset($property['GF20141105190410622745000000']) ? $property['GF20141105190410622745000000'] : null,
                            'gf_rooms' => isset($property['GF20141117181045021105000000']) ? $property['GF20141117181045021105000000'] : null,
                            'showing' => isset($property['GF20141105190919426700000000']) ? $property['GF20141105190919426700000000'] : null,
                            'gf_special_needs' => isset($property['GF20141105190839232975000000']) ? $property['GF20141105190839232975000000'] : null,
                            'style' => isset($property['GF20180123134656859287000000']) ? $property['GF20180123134656859287000000'] : null,
                            'tenant_pays' => isset($property['GF20141105190933387095000000']) ? $property['GF20141105190933387095000000'] : null,
                            'type_sale' => isset($property['GF20141105190730531759000000']) ? $property['GF20141105190730531759000000'] : null,
                            'utilities' => isset($property['GF20141105190946415363000000']) ? $property['GF20141105190946415363000000'] : null,
                            'water_sewer' => isset($property['GF20141105190303587949000000']) ? $property['GF20141105190303587949000000'] : null,
                            'windows' => isset($property['GF20141205184313434433000000']) ? $property['GF20141205184313434433000000'] : null,
                        ]);
                        break;
                    case 'B':
                        $propertySave->fill([
                            'garage_parking' =>  isset($property['GF20141111184659623250000000']) ? $property['GF20141111184659623250000000'] : null,
                            'owner' =>  isset($property['GF20180122211258777037000000']) ? $property['GF20180122211258777037000000'] : null,
                            'gf_appliances' =>  null,
                            'basement' =>  isset($property['GF20141111181912878437000000']) ? $property['GF20141111181912878437000000'] : null,
                            'bed_bath' =>  null,
                            'brick_stone' =>  isset($property['GF20191112201228804916000000']) ? $property['GF20191112201228804916000000'] : null,
                            'gf_community_features' =>  isset($property['GF20141111181913366554000000']) ? $property['GF20141111181913366554000000'] : null,
                            'cooling' =>  isset($property['GF20141111181914513396000000']) ? $property['GF20141111181914513396000000'] : null,
                            'description' =>  isset($property['GF20141111181915289784000000']) ? $property['GF20141111181915289784000000'] : null,
                            'dining' =>  null,
                            'documents' =>  isset($property['GF20150209175638163861000000']) ? $property['GF20150209175638163861000000'] : null,
                            'gf_equipment' =>  null,
                            'gf_exterior' =>  isset($property['GF20141111181918283208000000']) ? $property['GF20141111181918283208000000'] : null,
                            'exterior_features' =>  null,
                            'financing_available' =>  isset($property['GF20141111181919318145000000']) ? $property['GF20141111181919318145000000'] : null,
                            'gf_fireplace' =>  null,
                            'floors' =>  null,
                            'gf_foundation' =>  null,
                            'gf_furnished' =>  null,
                            'gf_garage' =>  null,
                            'gf_green_features' =>  null,
                            'heating' =>  isset($property['GF20141111181923474927000000']) ? $property['GF20141111181923474927000000'] : null,
                            'interior' =>  null,
                            'lease_terms' =>  null,
                            'gf_lot_description' =>  isset($property['GF20141111181925888821000000']) ? $property['GF20141111181925888821000000'] : null,
                            'gf_new_construction' => null,
                            'owner_pays' =>  isset($property['GF20141111181927348268000000']) ? $property['GF20141111181927348268000000'] : null,
                            'pool' =>  null,
                            'possession' =>  isset($property['GF20141111181927765464000000']) ? $property['GF20141111181927765464000000'] : null,
                            'roofing' =>  isset($property['GF20141111181928080917000000']) ? $property['GF20141111181928080917000000'] : null,
                            'gf_rooms' =>  null,
                            'showing' =>  isset($property['GF20141111181929137270000000']) ? $property['GF20141111181929137270000000'] : null,
                            'gf_special_needs' =>  isset($property['GF20141111181929697009000000']) ? $property['GF20141111181929697009000000'] : null,
                            'style' => null,
                            'tenant_pays' =>  isset($property['GF20141111181930176626000000']) ? $property['GF20141111181930176626000000'] : null,
                            'type_sale' =>  isset($property['GF20141111181930615541000000']) ? $property['GF20141111181930615541000000'] : null,
                            'utilities' => null,
                            'water_sewer' =>  isset($property['GF20141111181931391381000000']) ? $property['GF20141111181931391381000000'] : null,
                            'windows' =>  null,
                        ]);
                        break;
                    case 'C':
                        $propertySave->fill([
                            'garage_parking' => null,
                            'owner' => isset($property['GF20180122211721758754000000']) ? $property['GF20180122211721758754000000'] : null,
                            'gf_appliances' => null,
                            'basement' => null,
                            'bed_bath' => null,
                            'brick_stone' => null,
                            'gf_community_features' => isset($property['GF20210831124803981914000000']) ? $property['GF20210831124803981914000000'] : null,
                            'cooling' => null,
                            'description' => null,
                            'dining' => null,
                            'documents' => isset($property['GF20150209175705081093000000']) ? $property['GF20150209175705081093000000'] : null,
                            'gf_equipment' => null,
                            'gf_exterior' => null,
                            'exterior_features' => null,
                            'financing_available' => isset($property['GF20141205150512915209000000']) ? $property['GF20141205150512915209000000'] : null,
                            'gf_fireplace' => null,
                            'floors' =>  null,
                            'gf_foundation' => null,
                            'gf_furnished' =>  null,
                            'gf_garage' =>  null,
                            'gf_green_features' =>  null,
                            'heating' =>   null,
                            'interior' =>  null,
                            'lease_terms' =>  null,
                            'gf_lot_description' => isset($property['GF20141205150301729290000000']) ? $property['GF20141205150301729290000000'] : null,
                            'gf_new_construction' => null,
                            'owner_pays' =>   null,
                            'pool' =>  null,
                            'possession' => isset($property['GF20141205150412467963000000']) ? $property['GF20141205150412467963000000'] : null,
                            'roofing' =>   null,
                            'gf_rooms' =>  null,
                            'showing' => isset($property['GF20141205150247846923000000']) ? $property['GF20141205150247846923000000'] : null,
                            'gf_special_needs' =>   null,
                            'style' => null,
                            'tenant_pays' =>   null,
                            'type_sale' => isset($property['GF20141205150705700031000000']) ? $property['GF20141205150705700031000000'] : null,
                            'utilities' => isset($property['GF20141205150726465654000000']) ? $property['GF20141205150726465654000000'] : null,
                            'water_sewer' =>   null,
                            'windows' =>  null,
                        ]);
                        break;
                    case 'D':
                        $propertySave->fill([
                            'garage_parking' => null,
                            'owner' => isset($property['GF20180122211801077143000000']) ? $property['GF20180122211801077143000000'] : null,
                            'gf_appliances' => isset($property['GF20160124215510874589000000']) ? $property['GF20160124215510874589000000'] : null,
                            'basement' => isset($property['GF20160124215512180090000000']) ? $property['GF20160124215512180090000000'] : null,
                            'bed_bath' => isset($property['GF20160124215512048001000000']) ? $property['GF20160124215512048001000000'] : null,
                            'brick_stone' => isset($property['GF20191112201228811301000000']) ? $property['GF20191112201228811301000000'] : null,
                            'gf_community_features' => isset($property['GF20160124215512360728000000']) ? $property['GF20160124215512360728000000'] : null,
                            'cooling' => isset($property['GF20160124215512599544000000']) ? $property['GF20160124215512599544000000'] : null,
                            'description' => isset($property['GF20160124215513382492000000']) ? $property['GF20160124215513382492000000'] : null,
                            'dining' => isset($property['GF20160124215513303598000000']) ? $property['GF20160124215513303598000000'] : null,
                            'documents' => isset($property['GF20160124215512695326000000']) ? $property['GF20160124215512695326000000'] : null,
                            'gf_equipment' => isset($property['GF20160124215513740372000000']) ? $property['GF20160124215513740372000000'] : null,
                            'gf_exterior' => isset($property['GF20160124215513885235000000']) ? $property['GF20160124215513885235000000'] : null,
                            'exterior_features' => isset($property['GF20160124215513600267000000']) ? $property['GF20160124215513600267000000'] : null,
                            'financing_available' => isset($property['GF20160124215514035865000000']) ? $property['GF20160124215514035865000000'] : null,
                            'gf_fireplace' => isset($property['GF20160124215514501848000000']) ? $property['GF20160124215514501848000000'] : null,
                            'floors' => isset($property['GF20160124215514294191000000']) ? $property['GF20160124215514294191000000'] : null,
                            'gf_foundation' => isset($property['GF20160124215514448326000000']) ? $property['GF20160124215514448326000000'] : null,
                            'gf_furnished' => isset($property['GF20160124215514246184000000']) ? $property['GF20160124215514246184000000'] : null,
                            'gf_garage' => isset($property['GF20160124215514655984000000']) ? $property['GF20160124215514655984000000'] : null,
                            'gf_green_features' => isset($property['GF20160124215514781234000000']) ? $property['GF20160124215514781234000000'] : null,
                            'heating' => isset($property['GF20160124215515053649000000']) ? $property['GF20160124215515053649000000'] : null,
                            'interior' => isset($property['GF20160124215515195178000000']) ? $property['GF20160124215515195178000000'] : null,
                            'lease_terms' => isset($property['GF20160124215515685084000000']) ? $property['GF20160124215515685084000000'] : null,
                            'gf_lot_description' => isset($property['GF20160124215515312425000000']) ? $property['GF20160124215515312425000000'] : null,
                            'gf_new_construction' => null,
                            'owner_pays' => isset($property['GF20160124215515744483000000']) ? $property['GF20160124215515744483000000'] : null,
                            'pool' => isset($property['GF20160124215515803289000000']) ? $property['GF20160124215515803289000000'] : null,
                            'possession' => isset($property['GF20160124215515828251000000']) ? $property['GF20160124215515828251000000'] : null,
                            'roofing' => isset($property['GF20160124215515923185000000']) ? $property['GF20160124215515923185000000'] : null,
                            'gf_rooms' => isset($property['GF20160124215515998039000000']) ? $property['GF20160124215515998039000000'] : null,
                            'showing' => isset($property['GF20160124215519215502000000']) ? $property['GF20160124215519215502000000'] : null,
                            'gf_special_needs' => isset($property['GF20160124215519291080000000']) ? $property['GF20160124215519291080000000'] : null,
                            'style' => null,
                            'tenant_pays' => isset($property['GF20160124215519390088000000']) ? $property['GF20160124215519390088000000'] : null,
                            'type_sale' => isset($property['GF20160124215519462188000000']) ? $property['GF20160124215519462188000000'] : null,
                            'utilities' => isset($property['GF20160124215519544203000000']) ? $property['GF20160124215519544203000000'] : null,
                            'water_sewer' => isset($property['GF20160124215519643203000000']) ? $property['GF20160124215519643203000000'] : null,
                            'windows' => isset($property['GF20160124215519597101000000']) ? $property['GF20160124215519597101000000'] : null,
                        ]);
                        break;
                    default:
                        $propertySave->fill([
                            'garage_parking' => null,
                            'owner' => null,
                            'gf_appliances' => null,
                            'basement' => null,
                            'bed_bath' => null,
                            'brick_stone' => null,
                            'gf_community_features' => null,
                            'cooling' => null,
                            'description' => null,
                            'dining' => null,
                            'documents' => null,
                            'gf_equipment' => null,
                            'gf_exterior' => null,
                            'exterior_features' => null,
                            'financing_available' => null,
                            'gf_fireplace' => null,
                            'floors' => null,
                            'gf_foundation' => null,
                            'gf_furnished' => null,
                            'gf_garage' => null,
                            'gf_green_features' => null,
                            'heating' => null,
                            'interior' => null,
                            'lease_terms' => null,
                            'gf_lot_description' => null,
                            'gf_new_construction' => null,
                            'owner_pays' => null,
                            'pool' => null,
                            'possession' => null,
                            'roofing' => null,
                            'gf_rooms' => null,
                            'showing' => null,
                            'gf_special_needs' => null,
                            'style' => null,
                            'tenant_pays' => null,
                            'type_sale' => null,
                            'utilities' => null,
                            'water_sewer' => null,
                            'windows' => null,
                        ]);
                }

                $propertySave->save();
            }
        }
        return $dataOrganized;
    }

    public function storeImages()
    {
        $properties = Property::where('image', '=', '')->orWhereNull('image')->get();

        foreach ($properties as $property) {
            $imageUrl = $this->image($property->list_number);

            $property->update([
                'image' => $imageUrl
            ]);
        }

        return $properties;
    }
}
