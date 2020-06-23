<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;

use Validator;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;
use AMBERSIVE\Ardor\Models\ArdorMessage;
use AMBERSIVE\Ardor\Models\ArdorPrunableMessages;
use AMBERSIVE\Ardor\Models\ArdorDecryptedMessage;

use Illuminate\Validation\ValidationException;

class ArdorMessenger extends ArdorBase {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }
    
    /**
     * Send a message via ardor block chain
     * Pass additional params defined https://ardordocs.jelurida.com/Messages#Send_Message in $more
     *
     * @param  mixed $wallet
     * @param  mixed $message
     * @param  mixed $prunable
     * @param  mixed $more
     * @return void
     */
    public function sendMessage(String $wallet, String $message, bool $prunable = true, array $more = []): ArdorTransaction {

        $body = $this->mergeBody([
            'chain' => 2,
            'recipient' => $wallet,
            'message' => $message,
            'messageIsPrunable' => $prunable,
        ], $more, data_get($more,'secret', null), true);

        $response = $this->send("sendMessage", $body, false, 'form_params');

        return new ArdorTransaction($response);

    }
    
    /**
     * Read message 
     * Pass addtional params defined https://ardordocs.jelurida.com/Messages#Read_Message in $more 
     *
     * @param  mixed $fullHash
     * @param  mixed $chain
     * @param  mixed $secretPhrase
     * @param  mixed $more
     * @return void
     */
    public function readMessage(String $fullHash, int $chain = 0, String $secret = null, array $more = []) {

        $validator = Validator::make(['fullHash' => $fullHash, 'chain' => $chain], [
            'fullHash' => 'required|min:64|max:64',
            'chain' => 'int|min:1'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $body = $this->mergeBody([
            'transactionFullHash' => $fullHash,
            'chain' => $chain,      
        ], $more, $secret, true);

        $response = $this->send("readMessage", $body, false, 'form_params');
        
        return new ArdorMessage($response);

    } 
        
    /**
     * Get all prunable messages from node
     *
     * @param  mixed $chain
     * @param  mixed $more
     * @return ArdorPrunableMessages
     */
    public function getAllPrunableMessages(int $chain = 0, array $more = []):ArdorPrunableMessages {

        $body = $this->mergeBody([
            'chain' => $chain        
        ], $more, null, false);

        $response = $this->send("getAllPrunableMessages", $body, false, 'form_params');

        return new ArdorPrunableMessages($response);

    }
        
    /**
     * Returns the decrypted message
     * https://ardordocs.jelurida.com/Messages#Decrypt_From
     *
     * @param  mixed $account
     * @param  mixed $secret
     * @param  mixed $more
     * @return ArdorDecryptedMessage
     */
    public function decryptFrom(String $account, String $secret = null, array $more = []): ArdorDecryptedMessage {

        $body = $this->mergeBody([
            'account' => $account        
        ], $more, $secret, true);

        $response = $this->send("decryptFrom", $body, false, 'form_params');

        return new ArdorDecryptedMessage($response);

    }

}