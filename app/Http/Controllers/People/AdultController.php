<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\People;
use App\User;
use App\RelationType;
use App\Functions\HotelTool;
use App\UserCompanion;
use App\Http\Requests\People\UserRelatedPeople;
use App\Http\Requests\People\UserRelatedPeopleApproval;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRelatedPeople\ProfileAssociationApprovalRequest;
use App\Mail\PlainTextMail;


class AdultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('handlePersonAssociationApprovalRequest');
        $this->middleware('verified')->except('handlePersonAssociationApprovalRequest');
        $this->middleware('UserRelatedPersonValidationApproval')
        ->only('handlePersonAssociationApprovalRequest');
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

    /**
     * Store a newly created resource in storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(UserRelatedPeople $request)
    {  
        DB::begintransaction(); 
        $person = People::where('id_number',$request->id_number)->first();
        $user = User::where('id', Auth::id())->first();

        $companion = UserCompanion::onlyTrashed()->where('person_id', $person->id)
        ->where('user_id', $user->id)->get();
        if(count($companion)>0){
            $companion[0]->deleted_at = null;
            $companion[0]->created_at = Carbon::now();
            $companion[0]->updated_at = Carbon::now();
            $companion[0]->verified_at = null;
            if(!$companion[0]->save()){
                DB::rollback();
                return response()->json(['message'=>'Hubo un error al agregar la persona a su perfil, intente nuevamente.']);
            }
        } else {
            try{
                $user->companions()->attach($person->id);
            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['message'=>'Hubo un error al agregar la persona a su perfil, intente nuevamente.']);
            }
        }

        $token = Str::random(40);

        $companion = UserCompanion::where('user_id',$user->id)
        ->where('person_id', $person->id)->first();

        $companion->token=Hash::make($token);

        // $companion->token_verification= Carbon::now()->addHours(1)->format('Y-m-d H:i:s');
        $companion->token_verification=null;
        $companion->verified_at = null;

        $companion->relation_type_id = RelationType::where('type', $request->relation_type)
        ->first()->id;

        if(!$companion->save()){
            DB::rollback();
            return response()->json(['message'=>'Hubo un error al establecer la solicitud de aprobación, intente nuevamente.']);
        }        
        
        $dataToFilter = [
            ['fields'=>['locality_id', 'id_card_number_type_id',
            'address', 'phone_number', 'updated_at' ,'birth_date', 'created_at'],
            'entity'=>$companion->person],
            ['fields'=>['person_id', 'user_id',
            'updated_at', 'deleted_at', 'token','relation_type_id', 'token_verification'],
            'entity'=>$companion],
            ['fields'=>['id', 'is_underage_adult_relation'],
            'entity'=>$companion->relation_type],
        ];   
        
        foreach($dataToFilter as $data){
            HotelTool::ommitQueryFields($data['fields'], $data['entity']);
        }

        HotelTool::formatDates(['created_at', 'verified_at'], $companion);
        $message='La persona fue agregada exitosamente. ya puede agregarla a sus reservas.';

        if(count(User::where('person_id',$person->id)->get())>0){
        Mail::to($companion->person->user->email)
        ->send(new ProfileAssociationApprovalRequest($token, $companion->id, 
        $companion->person, Auth::user()->person, $companion->relation_type->type ));
        $message='La persona fue agregada exitosamente. Se envió una solicitud de aprobación al correo de la persona que agrego, una vez que esta la apruebe podrá agregarla a sus reservas.';
        }
        DB::commit();

        return response()->json(['message'=>$message,
        'companion'=>$companion,
        'success'=>'true']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    { return HotelTool::updateRelatedUserPerson('UserCompanion', $request, $id); }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companion = UserCompanion::Where('id', $id)->where('user_id', Auth::id())
        ->get();
        if(count($companion)<1){
            return response()->json([
                'message'=>'La persona que trata de eliminar '.
                'no pudo ser encontrada en sus personas asociadas. intente nuevamente']);
        }
        $companion=$companion[0];

        if($companion->delete()==1){
            return response()->json([
                'message'=>'La persona ' . $companion->person->name . ' ' . $companion->person->lastname .
                ' ha sido eliminada de sus personas asociadas, puede agregar nuevamente si lo desea, haciendo click en agregar persona e ingresando su número de pasaporte',
                'success'=>true]);
        }else {
            return response()->json([
                'message'=>'La persona ' . $companion->person->name . ' ' . $companion->person->lastname .
                'No pudo ser eliminada. intente nuevamente']);
        }
       
    }

    //own methods

    public function handlePersonAssociationApprovalRequest(Request $request){ 
        
        $companion = UserCompanion::where('id',$request->c)->first();
        // $companion->verified_at = Carbon::now();
        $companion->token = null;
        
        // if($request->a==1){ 
            
        //     $requester = $companion->user->person;

        //     if($companion->save()){
                
        //         Session::flash('message', 'Su perfil fue asociado existosamente. Ahora '
        //         . $requester->name . ' ' . $requester->lastname. ' puede agregarte a sus futuras reservas.');
                
        //         Mail::to($companion->user->email)
        //         ->send(new PlainTextMail( 'El usuario '. $companion->person->name . ' ' . $companion->person->lastname . 
        //         ' con número de pasaporte '. $companion->person->id_number .', aprobó su solicitud, ya puede agregar esta persona a sus futuras reservas.', 
        //         $companion->person->name . ' ' . $companion->person->lastname .' aprobó su solicitud'));

        //     }else {
        //         Session::flash('error_message', 'Su perfil no pudo ser asociado existosamente. '
        //         . $requester->name . ' ' . $requester->lastname. ' puede iniciar otra solicitud desde su perfil.'); 
        //     }
        //  }else {
            if($request->a=0){
                $companion->is_rejected=1;
                if($companion->save()){
                    
                    Session::flash('message', 'Solicitud rechazada existosamente. Si deseas que '
                    . $companion->user->person->name . ' ' . $companion->user->person->lastname. ' pueda solicitar agregarte nuevamente ingrese su número de pasaporte '.
                    'luego de hacer click en el botón desbloquear ubicado en la opción de personas del menú principal.'); 
                    

                }else {
                    Session::flash('error_message', 'Hubo un error con el rechazo de la solicitud.'); 
                }
            }
        //  }
        
        return redirect()->route('home');
    }
    public function resendAssociationApprovalRequest(Request $request){

        $companion = UserCompanion::where('id', $request->i)->first();
        $token=Str::random(40);
        $companion->token=Hash::make($token);

        $companion->token_verification= Carbon::now()->addHours(1)->format('Y-m-d H:i:s');

        if($companion->save()){
            Mail::to($companion->person->user->email)
            ->send(new ProfileAssociationApprovalRequest($token, $companion->id, 
            $companion->person, Auth::user()->person, $companion->relation_type->type ));

            return response()->json([
            'message'=>'El correo fue re-enviado exitosamente. Si en una hora no es procesado, podrá enviar otro.',
            'success'=>true]);
        }else {
            return response()->json([
                'message'=>'Hubo un problema al enviar el correo, intente nuevamente.',
                ]);
        }
        
    }
}
