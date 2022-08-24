<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyValidationFormRequest;
use App\Models\Balance;
use App\Models\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;
                    // Se o balance tiver algum valor retorna o balence->amount, senão retorna 0;
        return view('admin.balance.index', compact('amount'));
    }

    public function deposito(){

        return view('admin.balance.deposito');
    }

    public function depositoStore(MoneyValidationFormRequest $request){

        // 
       $balance = auth()->user()->balance()->firstorCreate([]);
       $response = $balance->deposito($request->value);

       if($response['success']){
        
            return redirect()->route('balance.index')->with('success', $response['message']);
       }
       return redirect()->back()->with('error', $response['message']);
    
    }


    public function withdraw(){

        return view('admin.balance.withdraw');
    }


    public function withdrawStore(MoneyValidationFormRequest $request)
    {
        
        $balance = auth()->user()->balance()->firstorCreate([]);
        $response = $balance->retirada($request->value);

       if($response['success']){
        
            return redirect()->route('balance.index')->with('success', $response['message']);
       }
       return redirect()->back()->with('error', $response['message']);
    }

    public function transfer(){

        return view('admin.balance.transfer');
    }

    public function confirmTransfer(Request $request, User $user){

        $sender = $user->getSender($request->sender);
        $balance = auth()->user()->balance;
       
        if(!$sender){

            return redirect()->back()->with('error', 'Usuario informado não foi encontrado');
        }

        if($sender->id === auth()->user()->id){

            return redirect()->back()->with('error', 'Não pode transferir para você');
        }
        

        return view('admin.balance.transfer-confirm', compact('sender', 'balance'));
    }

    public function transferStore(MoneyValidationFormRequest $request, User $user){

        $sender = $user->find($request->sender_id);
              
        if(!$sender){

            return redirect()->route('balance.tranfer')->with('error', 'Recebedor informado não foi encontrado');
        }

        $balance = auth()->user()->balance()->firstorCreate([]);
        $response = $balance->transfer($request->value, $sender);

       if($response['success']){
        
            return redirect()->route('balance.index')->with('success', $response['message']);
       }
       return redirect()->route('balance.transfer')->with('error', $response['message']);
 
    }


    public function historic()
    {
        $historics = auth()->user()->historics()->get();

        return view('admin.balance.historics', compact('historics'));
    }

}
