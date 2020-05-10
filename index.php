<?php
class Lotto {
    function getLotto(){    
        $urlWithoutProtocol = "https://www.lottery.co.th/";
        $request = "";
        $isRequestHeader = false;

        $exHeaderInfoArr   = array();
        $exHeaderInfoArr[] = "Content-type: text/xml";
        $exHeaderInfoArr[] = "Authorization: "."Basic ".base64_encode("authen_user:authen_pwd");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlWithoutProtocol);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HEADER, (($isRequestHeader) ? 1 : 0));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    
    function LottoA(){
        $getLotto = $this->getLotto();
        $Lotto_explode = explode('title="', $getLotto);
        //return $Lotto_explode;
        for($z = 37; $z <= 41; $z++){
            $LottoA_explode = explode('">', trim(strip_tags($Lotto_explode[$z])));
            $LottoA[] = $LottoA_explode['0'];
        }
        return $LottoA;
    }
    
    function LottoB(){
        $getLotto = $this->getLotto();
        $Lotto_explode = explode('<td >', $getLotto);
        for($z = 1; $z <= 167; $z++){
            $LottoB[] = substr(trim(strip_tags($Lotto_explode[$z])),0,6);
        }
        return $LottoB;
    }
    
    function LottoAll(){
        $LottoA = $this->LottoA();
        $LottoB = $this->LottoB();
        $LottoAll = array_merge($LottoA,$LottoB);
        return json_encode($LottoAll);
    }
}

echo '<pre>';
$Lotto = new Lotto();
$GetLottoAll = $Lotto->LottoAll();
print_r($GetLottoAll);
echo '</pre>';