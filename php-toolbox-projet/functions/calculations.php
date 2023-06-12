<?php

    function getPercent($percent = null, $of = null , $result =null){

        if($result === null){
            $result = $percent * $of / 100;

            return [
                'result' => $result,
            ];
        }
        if($percent === null){
            $percent = $of / $result * 100;

            return [
                'percent' => $percent,
            ];
        }
        if($of === null){
            $of = $result * 100 / $percent;

            return [
                'of' => $of,
            ];
        }
    }

    function ruleOfThird($a = 1, $b = 1, $c = 1): array
    {
        return [
            'd' => ($b * $c)  / $a,
        ];
    }

    function cesar($clear, $key, $reverse = false){
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $alphabet = str_split(strtoupper($alphabet));
        $clear = str_replace('"', " ", str_replace("'", " ", $clear));
        $clear = str_split(strtoupper($clear));
        $result = '';
        foreach ($clear as $letter){
            $index = array_search($letter, $alphabet);
            if ($index===false){
                $result .= strtoupper($letter);
            }else{
                $index = $reverse ? $index - $key : $index + $key;
                if ($index >= 0){
                    $index = $index%26;
                }else{
                    $index = ($index%26)+26;
                }
                
                $result .= $alphabet[$index];
            }
        }

        if($reverse){
            return [
                'clear' => $result,
            ];
        } else {
            return [
                'result' => $result,
            ];
        }
    }

    function temps($text){
        $total = 0;
        $len = strlen($text);
        $temp = '';
        $operateur = '+';
        $text = str_split($text);
        for ($i=0;$i<$len;$i++){

            switch ($text[$i]){
                case 'h':
                    $total = operation($total,$temp*3600,$operateur);
                    $temp = '';
                    break;
                case 'm':
                    $total = operation($total,$temp*60,$operateur);
                    $temp = '';
                    break;
                case 's':
                    $total = operation($total,$temp,$operateur);
                    $temp = '';
                    break;
                case '+':
                    $operateur = '+';
                    break;
                case '-':
                    $operateur = '-';
                    break;
                case (preg_match('/[1-9]/', $text[$i]) ? true : false):
                case '0':
                    $temp = $temp.$text[$i];
                    break;
                default:
                    return ['result' => $text[$i],];
            }
        }
        $jours = 0;

        while ($total>86400){
            $total = $total - 86400;
            $jours++;
        }

        $result = date("H\h i\m s\s",$total);

        return [
            'result' => $jours.' jours '.$result,
        ];
    }

    function operation($first,$second,$op){
        if($op == '+'){
            $result = $first + $second;
            return $result;
        }else if ($op == '-'){
            $result = $first - $second;
            return $result;
        }else{
            return 'Operateur non valide';
        }
    }

    function convertEuroDollars($euro = null, $dollars = null){
        $currency = $euro === null ? 'USD' : 'EUR';
        $reverseCurrency = $currency === 'EUR' ? 'USD' : 'EUR';

        $url = 'https://open.er-api.com/v6/latest/' . $currency;

        $data = file_get_contents($url);
        $data = json_decode($data, true);
        $rate = $data['rates'][$reverseCurrency];

        if($euro === null){
            $euro = $dollars * $rate;
            return [
                'EUR' => $euro,
            ];
        }
        if($dollars === null){
            $dollars = $euro * $rate;
            return [
                'USD' => $dollars,
            ];
        }
    }

    function convertDevise($from, $fromdevise, $todevise){
        $url = 'https://open.er-api.com/v6/latest/' . $fromdevise;

        $data = file_get_contents($url);
        $data = json_decode($data, true);
        $rate = $data['rates'][$todevise];

        $result = $from * $rate;

        return[
            'result' => $result,
        ];
    }

    function convertLiquide($from, $fromliquide, $toliquide){
        $result = round($from * $fromliquide / $toliquide,8);

        return[
            'result' => $result,
        ];        
    }