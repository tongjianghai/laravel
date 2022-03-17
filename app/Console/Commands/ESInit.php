<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class ESInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init laravel es for post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $hosts = config('scout.elasticsearch.hosts');
        $index = config('scout.elasticsearch.index');
        $url = $hosts['host'] . ":" . $hosts['port'] . '/_template/posts_template';

        // $client->delete($url);
        $param = [
            'json' => [
                'template' => $index,
                'mappings' => [
                    'enabled' => true,
                    'dynamic_templates' => [
                        [
                            'strings' => [
                                'match_mapping_type' => 'string',
                                'mapping' => [
                                    'type' => 'text',
                                    'analyzer' => 'ik_smart',
                                    'ignore_above' => 256,
                                    'fields' => [
                                        'keyword' => [
                                            'type' => 'keyword'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $client->put($url, $param);
        $url = $hosts['host'] . ":" . $hosts['port'] . "/" . $index;
        // $client->delete($url);
        $param = [
            'json' => [
                'settings' => [
                    'refresh_interval' => '5s',
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    'enabled' => false
                ]
            ]
        ];
        $client->put($url, $param);
    }
}
