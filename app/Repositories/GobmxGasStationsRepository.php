<?php


namespace App\Repositories;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GobmxGasStationsRepository
{

    const URL = 'https://api.datos.gob.mx/v2/precio.gasolina.publico';

    public function getByPostalCodes(array $postalcodes)
    {
        if (empty($postalcodes)) {
            return [];
        }
        $resources = [];

        // Lectura de cache.
        $request_postalcodes = [];
        foreach ($postalcodes as $postalcode) {
            $cache_name = $this->cache_name($postalcode);
            if (Cache::has($cache_name)) {
                $resources[] = Cache::get($cache_name);
            } else {
                $request_postalcodes[] = $postalcode;
            }
        }

        $response = [];
        if (count($request_postalcodes)) {
            $response = $this->requestPostalCodes($request_postalcodes);
            foreach ($response as $postalcode => $value) {
                Cache::rememberForever($this->cache_name($postalcode), function () use ($value) {
                    return $value;
                });
            }

        }

        $data = array_merge(
            Arr::collapse($resources),
            Arr::collapse($response)
        );

        $data = Collection::make($data)->filter(function ($g) {
            return !(empty($g['longitude']) && empty($g['latitude']));
        });

        return $data->values();
    }

    private function requestPostalCodes(array $postalcodes)
    {
        $curls = [];
        $multi_curl = curl_multi_init();
        foreach ($postalcodes as $postalcode) {
            $curl = $this->cURLByPostalCode($postalcode);
            $curls[$postalcode] = $curl;
            curl_multi_add_handle($multi_curl, $curl);
        }

        $cuurent_active = null;
        do {
            usleep(500);
            curl_multi_exec($multi_curl, $cuurent_active);
        } while ($cuurent_active > CURLM_OK);

        $resources = [];
        foreach ($curls as $postalcode => $curl) {

            $result = curl_multi_getcontent($curl);
            $result = json_decode($result, true);
            if (null == $result) continue;
            $resources[$postalcode] = $result['results'];
        }

        foreach ($curls as $curl) {
            curl_multi_remove_handle($multi_curl, $curl);
        }
        curl_multi_close($multi_curl);

        return $resources;
    }

    private function cURLByPostalCode($pc)
    {
        $query = http_build_query(['codigopostal' => $pc]);
        $url = static::URL . '?' . $query;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "utf-8",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 60
        ]);

        return $curl;
    }

    private function cache_name($cp)
    {
        return 'gobmx.gasstation.' . $cp;
    }
}