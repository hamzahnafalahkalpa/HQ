<?php

namespace Projects\Hq\Supports;

use Hanafalah\LaravelSupport\Concerns\Support\HasCache;
use Projects\Hq\Contracts\Supports\ServiceCache as SupportsServiceCache;
use Illuminate\Support\Str;

class ServiceCache implements SupportsServiceCache{
    use HasCache;

    protected $__cache_data = [
        'hq' => [
            'name'    => 'app-hq',
            'tags'    => ['hq','app-hq'],
            'forever' => true
        ]
    ];

    public function handle(?array $cache_data = null): void{
        $cache_data ??= $this->__cache_data['hq'];
        $this->setCache($cache_data, function(){
            $cache = [
                'app.cached_lists' => [
                    'app.contracts',
                    'database.models',
                    'hq.packages',
                    'config-cache'
                ],
                'app.contracts'         => config('app.contracts'),
                'database.models'       => config('database.models'),
                'hq.packages'           => config('hq.packages'),
                'configs' => []
            ];            

            foreach (config('hq.packages') as $key => $value){
                $key = Str::kebab(Str::after($key, '/'));
                $cache['configs'][$key] = config($key);
            }

            config([
                'app.cached_lists' => $cache['app.cached_lists'] ?? [],
                'app.contracts'    => $cache['app.contracts'] ?? [],
                'database.models'  => $cache['database.models'] ?? [],
                'hq.packages'     => $cache['hq.packages'] ?? [],
                'configs' => $cache['configs'] ?? []
            ]);
            return $cache;
        }, false);
    }   

    public function getConfigCache(): ?array{
        $cache_data = $this->__cache_data['hq'];
        $cache = $this->getCache($cache_data['name'],$cache_data['tags']);
        if (isset($cache)){
            config([
                'app.cached_lists' => $cache['app.cached_lists'] ?? [],
                'app.contracts'    => $cache['app.contracts'] ?? [],
                'database.models'  => $cache['database.models'] ?? [],
                'hq.packages'      => $cache['hq.packages'] ?? [],
                'configs'          => $cache['configs'] ?? []
            ]);
            foreach ($cache['configs'] as $key => $config) {
                config([$key => $config]);
            }
        }
        return $cache;
    }
}