<?php

namespace App\Services;

use App\Models\Localidade;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Models\ValidationJuno;
use App\Models\User;
use App\Repository\JunoRepositoryInterface;
use App\Repository\UserRepositoryInterface;



class JunoService{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
      private $junoRepositoryInterface;
      private $userRepositoryInterface;
      protected $token_juno;
    //  private $token_juno="eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiJicHBlZHJvMzlAZ21haWwuY29tIiwic2NvcGUiOlsiYWxsIl0sImV4cCI6MTYxOTYxMjkwNSwianRpIjoiUXpOOU9xbTZ0VEcwR0hYMWFoRnBIbjlJeDdnIiwiY2xpZW50X2lkIjoiM1lzVWt1UzZWTUNOeWlkYyJ9.dKdAPVYN3u7Qtkf4TVmurCyDrcU6WhQn8xCHyw9Q27FAUjb81tZjXWPblcM1ZjRN7Y3tc9W0m4y7YcW2qKNJtL_s9oHYtzuTB7j6VGP8sRLoig0IVtF7DBOkH-wLnFBtWoedIcw9VC6nrRPtL7SbLQSa34LXycDQQ1DbZOYxUOXGT4JeW9sFV4DVC_Fwgc1b0G6wdBemq6ScWTUe-ykI6TTrie82aw4MFZBgYlok504TRdg1zeqyaAJkmX-xlqq95R9ZDK7Po3ezMJUCqhw_erUBPqG0yQFn7NFLGiM_hEDw5uZvYP3n-AUVllm0GDP7-EkItn7sE2bqnQXAV8PaZQ";
      private $clientId ="4iz1IDvJapSduWXD";
      private $clientSecret ="i[IUteOe48edr?W5,;|1c{OusmS@bJbj";
      private $token_privado="7BF795BC8021847956C98CDAE9F43F643CF7F4E04FAE660D98CE904B8C56C66F";
      private $token_publico="0041D7496C9C14E56D000DD1464839E56DEBF9F667836B2C90ACECB2CBE4B1B4F6E0B8E089EE6181";

      private  $charge = array(
        'description' => "Plano mensal de acesso ao conteúdo à VideoTeca polular",
        'references' => ["Assinatura"],
        'amount' => 5,
        'installments' => 1,
        'paymentTypes' => ["CREDIT_CARD"]
    );



    public function __construct(JunoRepositoryInterface $junoRepositoryInterface, UserRepositoryInterface $userRepositoryInterface) {
      //  $this->token_juno=$this->Autenticable();
         $this->token_juno=$this->Autenticable();

         $this->junoRepositoryInterface=$junoRepositoryInterface;
         $this->userRepositoryInterface=$userRepositoryInterface;
    }
        //

        private function Autenticable():String{

        $base64 = base64_encode("{$this->clientId}:{$this->clientSecret}");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.juno.com.br/authorization-server/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_POST=> true,
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.$base64,
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = json_decode(curl_exec($curl), true);
        return  $response['access_token'];
        curl_close($curl);
    }




    private function header($link){
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$this->token_juno}",
            "X-API-Version: 2",
            "X-Resource-Token: {$this->token_privado}",
            "Content-Type: application/json;charset=UTF-8"

        ]);
        $resultado = json_decode(curl_exec($ch));
        return $resultado;
    }


    public function balance(){
        $link="https://api.juno.com.br/balance";
        var_dump($this->header($link)->balance);
       // $this->balanceHeader();
    }


    public function token(){
        return response($this->token_juno);
    }

    //função que cria a cobrança
    public function cobranca($billing,$user_id){

            $chargs= json_encode($this->charge);
            $billings= json_encode($billing);
            try {

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.juno.com.br/charges',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "charge":'.$chargs.',
                        "billing":'.$billings.'

                        }
                    }
                    ',
                    CURLOPT_HTTPHEADER => array(
                        "X-API-Version: 2",
                        "X-Resource-Token: {$this->token_privado}",
                        "Content-type: application/json",
                        "Authorization: Bearer {$this->token_juno}"
                    ),
                    ));

                   $response =json_decode(curl_exec($curl), true);;
                //  $response =curl_exec($curl);



                 //  return response()->json($local);
                   //  $response['_embedded']['charges'][0];


                   $cobranca=array("cobranca_id"=>$response['_embedded']['charges'][0]['id'],
                                    "code"=>$response['_embedded']['charges'][0]['code'],
                                    "reference"=>$response['_embedded']['charges'][0]['reference'],
                                    "status"=>"Activo",
                                    "date"=>$response['_embedded']['charges'][0]['dueDate'],
                                    'user_id'=>$user_id);
                    $this->junoRepositoryInterface->setCobranca($cobranca);

                   //
                    return $cobranca["cobranca_id"];
                    curl_close($curl);

                } catch (QueryException $exception) {
                    return response()->json(['error' => 'erro de conexão com a base de dados ' . $exception], Response::HTTP_INTERNAL_SERVER_ERROR);
                }


    }

    public function pagamento($adress,$creditCardId, $chargeId,$email){




            $billing=array(
                'email' => $email,
                'address'=> $adress
            );

            $creditCardDetails=array(
                'creditCardId'=> $creditCardId
            );

            $charge=array(

                "chargeId"=>$chargeId,
                "billing"=>$billing,
                "creditCardDetails"=>$creditCardDetails
            );
            $chargs= json_encode($charge);
            try {

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.juno.com.br/payments',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$chargs,
                    CURLOPT_HTTPHEADER => array(
                        "X-API-Version: 2",
                        "X-Resource-Token: {$this->token_privado}",
                        "Content-type: application/json",
                        "Authorization: Bearer {$this->token_juno}"
                    ),
                    ));
                    $response=curl_exec($curl);
                    //curl_close($curl);

            /*        $response =json_decode(curl_exec($curl), true);
                    $pagamento=array(
                        "paymentsId"=>$response['transactionId'][0],
                        "status"=>$response['payments']['status'][0],
                        "chargeId"=>$response['payments']['chargeId'][0],
                        "amount"=>$response['payments']['amount'][0],
                        "date"=>$response['payments']['date'][0]
                   );*/
    //$this->junoRepositoryInterface->pagamento($pagamento);


                    curl_close($curl);
                   // echo $response;
                    return true;
                } catch (QueryException $exception) {
                    return false;
                }


    }


//funcão que tokeniza o cartão e cria também o creditId
public function integracao($request,$id){
    $date=$request['data_nascimento'];
    $billing=array(
        'name' =>  $request['nome_completo'],
        'email' => $request['email'],
        'document' => $request['cpf'],
        'notify' => true
    );
    $adress = array(
        'city'=>$request['cidade'],
        'street'=>$request['rua'],
        'number'=>$request['numero'],
        'state'=>$request['estado'],
        'postCode'=>$request['cep'],
    );

    $card=$this->card($request['hash'],$id);
    $cobranca=$this->cobranca($billing,$id);
    $this->pagamento($adress,$card,$cobranca,$billing["email"]);

}
    public function card($hash,$id){
        try{

            $cardId=$this->tokenCard($hash);
            $card=array("hash"=>$hash,
                        "creditId"=> $cardId,
                        "user_id"=>$id
                    );
            $this->junoRepositoryInterface->card($card);
            return $cardId;
        }catch(QueryException $exception){
            return $exception;
        }

    }
    public function emitirCobranca(){
        return $this->token_publico;

    }
//função que cria o CreditId
    public function tokenCard($card){
    try{
        $hash=array("creditCardHash"=>$card);
        $hashs=json_encode($hash);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.juno.com.br/credit-cards/tokenization',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST=> true,
            CURLOPT_POSTFIELDS =>$hashs,
            CURLOPT_HTTPHEADER => array(
                "X-API-Version: 2",
                "X-Resource-Token: {$this->token_privado}",
                "Content-type: application/json",
                "Authorization: Bearer {$this->token_juno}"
            ),
            ));
            $response = json_decode(curl_exec($curl), true);
            curl_close($curl);

            return $response['creditCardId'];
        }catch(QueryException $exception){
            return $exception;
        }


    }




}
