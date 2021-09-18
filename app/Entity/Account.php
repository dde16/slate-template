<?php

namespace App\Entity {

    use Slate\Neat\Attribute\Column;
    use Slate\Neat\Attribute\OneToMany;
    use Slate\Neat\Attribute\OneToOne;
    use Slate\Neat\Entity;

    class Account extends Entity {
        public const SCHEMA = "slate";
        public const TABLE  = "account";

        #[Column]
        public ?int $id = null;

        #[Column]
        public string $uid;
        
        #[Column]
        public string $username;

        #[OneToMany("uid", [AccountCookie::class, "accountUid"])]
        public $cookies;
    }
}

?>