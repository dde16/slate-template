<?php

namespace App\Entity {

    use Slate\Neat\Attribute\Column;
    use Slate\Neat\Entity;

    class AccountCookie extends Entity {
        public const SCHEMA = "slate";
        public const TABLE = "cookie";

        #[Column]
        public ?int $id = null;
        
        #[Column("account_uid")]
        public string $accountUid;

        #[Column]
        public string $value;
    }
}

?>