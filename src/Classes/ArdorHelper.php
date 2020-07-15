<?php 

namespace AMBERSIVE\Ardor\Classes;

class ArdorHelper {

    /**
     * Sign a transaction by using the ardorsign cli
     *
     * @param  mixed $message
     * @param  mixed $secret
     * @return void
     */
    public static function signTransaction(String $message, String $secret): array{
        exec("ardorsign --transaction='${message}' --secret='${secret}'", $output);
        return $output;
    }

}