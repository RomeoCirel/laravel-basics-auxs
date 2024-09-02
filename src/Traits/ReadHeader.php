<?php

namespace Cirel\LaravelBasicsAuxs\Traits;

use App\Models\Country;
use App\Models\Strategy;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Position;

trait ReadHeader
{

    protected function getIp(Request $request)
    {
        $ip = $request->header('x-original-forwarded-for') ?? null;
        if ($ip) {
            return $ip;
        }

        $ip = $request->header('X-Real-IP') ?? null;
        if ($ip) {
            return $ip;
        }

        $ip = $request->header('X-Forwarded-For') ?? null;
        if ($ip) {
            return $ip;
        }

        $ip = $request->ip();
        if ($ip) {
            return $ip;
        }

        return null;
    }

    protected function getUserAgent(Request $request)
    {
        return $request->header('User-Agent');
    }

    protected function getLocation(Request $request, $ip = null): Position|bool
    {
        $searchedIp = isset($ip) ? $ip : $this->getIp($request);
        return Location::get($searchedIp);
    }

    protected function getCountryPhoneCodeByCountryCode(string $countyCode)
    {
        return Country::where('country_code', $countyCode)->first()->phone_code;
    }

    protected function getCountryByPhone(string $phone): Country | null
    {
        $countries = Country::all();
        return $countries->first(function ($country) use ($phone) {
            $array = explode(',', $country['phone_code']);
            foreach ($array as $item) {
                $poneCode = substr($phone, 0, strlen($item));
                if ($poneCode == $item) {
                    return true;
                }
            }
            return false;
        });
    }

    protected function getCountryPhoneCodeByIp(Request $request)
    {
        $location = $this->getLocation($request);
        if ($location) {
            return $this->getCountryPhoneCodeByCountryCode($location->countryCode);
        }
        return null;
    }

    protected function getAniFromHeader(Request $request): string | null
    {
        $strategy = Strategy::findOrFail(1);
        $keys = $strategy->configs()->select('param_key')->get()->toArray();
        foreach ($keys as $key) {
            $value = $request->header($key['param_key']);
            if ($value) {
                return $value;
            }
        }
        return null;
    }

}
