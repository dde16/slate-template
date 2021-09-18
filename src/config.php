<?php

return [
    // Not required
    "mvc.title"                => "Vex",

    // All of the following are required 
    "mvc.public.path"          => "/public",
    "mvc.view.path"            => "/view",
    "mvc.index.path"           => "/home",

    // Required to get the ORM working
    "orm.cache.repository" => "fs:ssd",

    // Whether to use the internal error printer
    "mvc.verbose"              => true,

    // @see Slate\Mvc\RepoFactory for available repositories
    "repositories" => [
        // Use ipcs -m to view shared memory
        "shm:ratelimiter" => [
            "type"        => "memory",
            "key"         => 1488,
            "size"        => 12*(1024**2),
            "permissions" => 0600
        ],
        "fs:ssd" => [
            "type"        => "filesystem",
            "directory"   => __DIR__."/../cache"
        ]
    ],

    // @see Slate\Sql\SqlConnectionFactory for supported drivers
    "connections" => [
        "mysql" => [
            "default"  => true,
            "driver"   => "mysql",
            "hostname" => "localhost",
            "username" => "",
            "password" => "",
        ]
    ],
    
    // @see Slate\Mvc\QueueFactory for available queues
    // "queues" => [
    //     "primary" => [
    //         "type"        => "persistent-memory-table",
    //         "key"         => 5151,
    //         "permissions" => 0666,
    //         "rows"        => 5000,
    //         "conn"        => "mysql",
    //         "source"      => ["schema", "table"]
    //     ]
    // ]
];

?>