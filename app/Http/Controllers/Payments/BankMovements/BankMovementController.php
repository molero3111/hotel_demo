<?php

namespace App\Http\Controllers\Payments\BankMovements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use App\TableName;
use App\PolymorphicLog;
use App\Functions\HotelTool;
use App\Room;
use App\RoomType;
use App\Payment;
use App\BankMovement;
use App\BankAccount;
use App\Bank;
use Carbon\Carbon;

class BankMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $bank_accounts = BankAccount:: where('is_primary_account', true)->get();
        $banks = Bank::all();
        foreach($banks as $bank){ 

            $field_sets=null;
            if(count(
                BankAccount::where('is_primary_account', true)->where('bank_id', $bank->id)
                ->get())>0
            ){
                $bank->currency;
                $field_sets=[
                    ['fields'=>['id', 'currency_id', 'abbreviation'],
                    'entity'=>$bank],
                    ['fields'=>['id', 'name', 'symbol', 'dollar_equivallent'],
                    'entity'=>$bank->currency],
                ];
                foreach($field_sets as $set){
                    HotelTool::ommitQueryFields($set['fields'], $set['entity']);
                }
                $bank->currency=$bank->currency->iso_code_abbreviation;
            }
        }
        return compact('banks');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return ['field'=>$request->total];
        $bank = Bank::where('name', $request->bank )->first();
        $bank_account_id= BankAccount::where('bank_id', $bank->id)->where('is_primary_account', true)->first()->id;
        $payment = BankMovement::create([
           'payment_id'=>$request->payment_id,
           'bank_account_id'=> $bank_account_id,
           'reference_number'=> $request->reference,
           'paid_at'=>$request->payment_date,
           'total'=>$request->total,
           'payment_type_id'=> 1,
           'equivallent_in_dollars'=>$bank->currency->equivallent_in_dollars

       ]);
       if($payment){
           return response()->json(['success'=>true, 'message'=>'Su pago fue registrado exitosamente, pronto sera verificado por nuestro personal.']);
       }else {
            return response()->json(['message'=>'Su pago no pudo ser procesado, intente nuevamente.']);
       }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank_movement=BankMovement::where('id', $id)->first();
        $success=true;
        $dates=['paid_at', 'created_at'];
        if($bank_movement->verified_at==null){ array_push($dates, 'verified_at');}
        else{$bank_movement->verified_at='En proceso.';}
        foreach($dates as $date){
            $bank_movement[$date]= new Carbon($bank_movement[$date]);
            $bank_movement[$date]=$bank_movement[$date]->format('d-m-Y H:i:s');
        }
        $bank_movement->payment_type; 
        $bank_movement->bank_account->bank->currency;       
        return compact('bank_movement', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
