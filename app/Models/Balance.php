<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;

class Balance extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function deposito($value) : Array
    {   
        DB::beginTransaction(); // estudar junto com commit e rollback

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format($value, 2, '.');
        $deposito = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'I',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);


        if($deposito && $historic){
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao recarregar'
            ];

        }else{
            DB::rollBack(); //desfaz toda a operação 
            return [
                'success' => false,
                'message' => 'Falha ao recarregar'
            ];
        }
    }

    public function retirada($value) : Array
    {   
        if($this->amount < $value){
            return [
                'success' => False,
                'message' => 'Saldo insuficiente',
            ];
        }


        DB::beginTransaction(); // estudar junto com commit e rollback

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.');
        $retirada = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => 'O',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd'),
        ]);


        if($retirada && $historic){
            DB::commit();

            return [
                'success' => true,
                'message' => 'Saque realizado com sucesso'
            ];

        }else{
            DB::rollBack(); //desfaz toda a operação 
            return [
                'success' => false,
                'message' => 'Falha ao sacar'
            ];
        }
       
    }

    public function transfer($value, User $sender): Array
    {
        if($this->amount < $value){
            return [
                'success' => False,
                'message' => 'Saldo insuficiente',
            ];
        }


        DB::beginTransaction(); // estudar junto com commit e rollback
        
        // Atualizando o proprio saldo
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.');
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'                => 'T',
            'amount'              => $value,
            'total_before'        => $totalBefore,
            'total_after'         => $this->amount,
            'date'                => date('Ymd'),
            'user_id_transaction' => $sender->id
        ]);

        //Atualiza o saldo do recebedor        
        $senderBalance = $sender->balance()->firstOrCreate([]);// firstOrCreate : vai procurar, se não existir vai criar.
        $totalBeforeSander  = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($value, 2, '.');
        $transferSender = $senderBalance->save();

        $historicSender = $sender->historics()->create([
            'type'                => 'I',
            'amount'              => $value,
            'total_before'        => $totalBeforeSander,
            'total_after'         => $senderBalance->amount,
            'date'                => date('Ymd'),
            'user_id_transaction' => auth()->user()->id,
        ]);





        if($transfer && $historic && $transferSender && $historicSender){
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao transferir'
            ];

        }
        DB::rollBack(); //desfaz toda a operação 
        return [
            'success' => false,
            'message' => 'Falha ao sacar'
        ];
        
       
    }        
}
