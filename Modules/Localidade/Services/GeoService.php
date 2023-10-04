<?php

namespace Modules\Localidade\Services;


use App\Services\ConfiguracaoService;
use App\Services\UtilService;

class GeoService
{

    /**
     * @var UtilService
     */
    private $utilService;
    /**
     * @var ConfiguracaoService
     */
    private $configuracaoService;

    public function __construct(
        UtilService $utilService,
        ConfiguracaoService $configuracaoService)
    {
        $this->utilService = $utilService;
        $this->configuracaoService = $configuracaoService;
    }

    /**
     * @param array $origens ['lat'=>'0','long'=>'0'] ou [ 0 => ['lat'=>'0','long'=>'0']]
     * @param array $destinos
     * @return null
     */
    public function distanceCalculate(array $origens, array $destinos, $taxa = 0.4)
    {
        /*$cachePosition =  $this->geoPosition->skipPresenter(false)->getPosition($origens,$destinos);
        if($cachePosition){
            return $cachePosition;
        }*/
        $origensFormat = "";
        $destinosFormat = "";
        if (is_numeric(key($origens))) {
            $contOrigens = count($origens);
            foreach ($origens as $origem) {
                $origensFormat .= $this->formatLocation($origem) . ($contOrigens > 1 ? '|' : '');
            }
        } else {
            $origensFormat = $this->formatLocation($origens);
        }

        if (is_numeric(key($destinos))) {
            $contDestinos = count($destinos);
            foreach ($destinos as $destino) {
                $destinosFormat .= $this->formatLocation($destino) . ($contDestinos > 1 ? '|' : '');
            }
        } else {
            $destinosFormat = $this->formatLocation($destinos);
        }

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origensFormat&destinations=$destinosFormat&mode=driving&language=pt-BR";
        $response_a = json_decode($this->utilService->curlFunction($url), true);
        if ($response_a['rows'][0]['elements'][0]['status'] == 'ZERO_RESULTS') {
            abort(303, 'Localização não encontrada');
        }

        $distanciaTotal = 0;
        $duracaoPrevista = 0;
        foreach ($response_a['rows'] as $v => $item) {
            foreach ($item['elements'] as $key => $value) {
                $distanciaTotal += (double)str_replace(',', '.', $value['distance']['text']);
                $duracaoPrevista += (double)str_replace(',', '.', $value['duration']['text']);
            }
        }
        //$total = ($distanciaTotal * 2) * 0.51875;
        /*return $this->geoPosition->create([
            'lat_log_origens'=>$origens,
            'lat_log_destinos'=>$destinos,
            'price' =>floatval($total)
        ]);*/
        $configuracao = $this->configuracaoService->getConfiguracao();
        $calc = $configuracao['data'];
        $valorMinimo = ($calc['vlkm'] * $calc['nmkm']) + ($calc['vlmin'] * $calc['nmmin']) + $calc['vlsegp'] + ($calc['vlkmr'] * $distanciaTotal);
        $currentTime = (new \DateTime());
        $startTime = new \DateTime('06:00');
        $endTime = (new \DateTime('23:59'));
        if ($currentTime >= $startTime && $currentTime <= $endTime) {
            $total = ($calc['vlkm'] * $distanciaTotal) + ($calc['vlmin'] * $duracaoPrevista) + $calc['vlsegp'] + ($calc['vlkmr'] * $distanciaTotal);
        }else{
            $total = ($calc['vlkm'] * $distanciaTotal) + ($calc['vlmin'] * $duracaoPrevista) + $calc['vlsegp'] + ($calc['vlkmr'] * $distanciaTotal);
            $total = $total+($total*$calc['pkmm']);
        }
        $tx_uso_malha = $calc['vlkmr']*$distanciaTotal;
		$tarifa_operacao = ($total-$tx_uso_malha)*($calc['ptxoper']);
        //dd($total, $tx_uso_malha, $calc['ptxoper'], $tarifa_operacao);
        return [
            'valor'=>(($total < $valorMinimo) ? $valorMinimo : $total),
            'duracao'=>$duracaoPrevista,
			'distanciatotal' => $distanciaTotal,
			'tx_uso_malha' => $tx_uso_malha,
			'tarifa_operacao' => $tarifa_operacao,//(Vlcor- vltxmpub) X (%txoper-%bonusm))
			'valor_repasse'=> $total-$tarifa_operacao-$tx_uso_malha,
        ];
    }

    private function formatLocation($location)
    {
        return implode(',', array_values($location));
    }

    public function getSinglePosition($cidade, $endereco, $estado)
    {
        $address = urlencode($cidade . ',' . $endereco . ',' . $estado);
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Brazil";
        $response_a = json_decode($this->utilService->curlFunctionProxy($url));
        $status = $response_a->status;
        //dd('lat =>'.$response_a->results[0]->geometry->location->lat. ' long =>'.$response_a->results[0]->geometry->location->lng);
        if ($status == 'ZERO_RESULTS') {
            return FALSE;
        } else {
            $return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
            return $return;
        }
    }


}