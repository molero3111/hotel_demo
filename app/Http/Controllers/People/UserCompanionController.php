<?php

namespace App\Http\Controllers\People;

//models
use App\People;
use App\User;
use App\RelationType;
use App\UserCompanion;
use App\IdCardNumberType;
//others
use App\Functions\HotelTool;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

//mailables
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRelatedPeople\ProfileAssociationApprovalRequest;
use App\Mail\PlainTextMail;


//form requests

use App\Http\Requests\People\UserPeopleRequest;
use App\Http\Requests\People\UpdateUserPeopleRequest;

class UserCompanionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() { return HotelTool::getRelatedUserPeople('UserCompanion'); }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    
    public function store(UserPeopleRequest $request)  { 
        
        $create=false;
        $message='Persona asociada exitosamente a su perfil, ya la puede agregar a sus reservas de hotel';
        $success=true;
        // $companion = UserCompanion::onlyTrashed()->where('id_number', $request->id_number)
        // ->orWhere()->get();

        $companion = UserCompanion::onlyTrashed()->where('user_id', Auth::id())
        ->orWhere(function($query) use($request) {
                $query->where('id_number', $request->id_number)
                      ->where('email', $request->email);
        })->get();

        if(count($companion)==1 && $companion[0]->restore()){
            $companion[0]->relation_type_id=RelationType::where('type', $request->relation_type)
            ->first()->id;
            $companion[0]->id_card_number_type_id=IdCardNumberType::
            where('abbreviation', $request->id_number_type)->first()->id;
            $companion[0]->id_number=$request->id_number;
            $companion[0]->name=$request->name;
            $companion[0]->lastname=$request->lastname;
            $companion[0]->phone_number=$request->phone_number;
            $companion[0]->email=$request->email;
            $companion[0]->address=$request->address;
            $companion[0]->birth_date=$request->birth_date;

            if(!$companion[0]->save()){$message='No se pudo agregar la persona...';
            $success=false; }
            else {$create=true;}

        }
        else if (count($companion)>1){
            $message='Hay un problema con los datos de la persona a agregar.';
            $success=false;
        }else {
        
            $create = UserCompanion::create(['user_id'=>Auth::id(), 
            'relation_type_id'=>RelationType::where('type', $request->relation_type)->first()->id,
            'id_card_number_type_id'=>IdCardNumberType::where('abbreviation', $request->id_number_type)->first()->id, 
            'id_number'=>$request->id_number, 'name'=>$request->name,
            'lastname'=>$request->lastname,
            'phone_number'=>$request->phone_number, 'email'=>$request->email, 
            'address'=>$request->address, 'birth_date'=>$request->birth_date
            ]);
        }
       
        if($create==false){ $message='Hubo un error al agregar la persona.'; $success=false;}

        return response()->json(['message'=>$message, 'success'=>$success]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {    
        $companion = UserCompanion::where('id', $id)->where('user_id', Auth::id())
        ->select(['relation_type_id', 'id_card_number_type_id', 'id_number',
        'name', 'lastname', 'phone_number', 'email', 'address', 'birth_date'])->first();

        if(!$companion){ return response()->json([
            'message'=>'No se encontró la persona seleccionada.'
            ]);
        }

        $relation_type = RelationType::where('id', $companion->relation_type_id)
        ->select('type')->first();

        if(!$relation_type){ return response()->json([
            'message'=>'No se encontró el tipo de relación de la persona seleccionada.'
            ]);
        }

        $id_number_type = IdCardNumberType::where('id', $companion->id_card_number_type_id)
        ->select('abbreviation')->first();

        if(!$id_number_type){ return response()->json([
            'message'=>'No se encontró el tipo de identificación de la persona seleccionada.'
            ]);
        }
        return compact('companion', 'relation_type', 'id_number_type');
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
    public function update(UpdateUserPeopleRequest $request, $id)
    {
        $message; $success=false;
        
        $companion = UserCompanion::where('id', $id)->where('user_id', Auth::id())
        ->first();

        if (!$companion) {
            return response()->json(['message'=>'Persona no encontrada',
            'success'=>$success]); 
        }
        
        $companion->id_card_number_type_id=IdCardNumberType::
        where('abbreviation', $request->id_number_type)->first()->id;
        $companion->id_number=$request->id_number; 
        $companion->name=$request->name;
        $companion->lastname=$request->lastname;
        $companion->address=$request->address;
        $companion->phone_number=$request->phone_number;
        $companion->birth_date=$request->birth_date;
        $companion->email=$request->email;
        $companion->relation_type_id=RelationType::where('type', $request->relation_type)
        ->first()->id;  
        if(!$companion->save()){  $message='No se puedo actualizar la persona.'; }
        else {
            $message='Persona actualizada exitosamente';
            $success=true;
        } 
        return response()->json(['message'=>$message, 'success'=>$success]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companion = UserCompanion::Where('id', $id)
        ->where('user_id', Auth::id())->get();
        if(count($companion)<1){
            return response()->json([
                'message'=>'La persona que trata de eliminar '.
                'no pudo ser encontrada en sus personas asociadas. intente nuevamente']);
        }
        $companion=$companion[0];
        if($companion->delete()==1){
            return response()->json([
                'message'=>'La persona ' . $companion->name . ' ' . $companion->lastname .
                ' ha sido eliminada de sus personas asociadas.',
                'success'=>true]);
        }else {
            return response()->json([
                'message'=>'La persona ' . $companion->name . ' ' . $companion->lastname .
                'No pudo ser eliminada. intente nuevamente']);
        }
    }
}
