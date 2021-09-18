<?php

namespace App\Entity {

    use Slate\Neat\Attribute\Column;
    use Slate\Neat\Attribute\Fillable;
    use Slate\Neat\Attribute\Initialiser;
    use Slate\Neat\Attribute\OneToMany;
    use Slate\Neat\Attribute\OneToOne;
    use Slate\Neat\Entity;

    class Account extends Entity {
        public const SCHEMA = "slate";
        public const TABLE  = "account";

        /**
         * Auto Increment Primary keys must be nullable as when created will be null
         * 
         */
        #[Column]
        public ?int $id = null;

        /**
         * Fillable is equivalent to Laravel fillable.
         */
        #[Column]
        #[Fillable]
        public string $uid;
        
        /**
         * Column names will be mapped to their property names by
         * specifying it in the Column attribute constructor.
         */
        #[Column("username")]
        #[Fillable]
        public string $username;

        /**
         * OneToMany(localProperty, [foreignClass, foreignProperty])
         * ALL parts of the ORM will always use the mapped property
         * names for mapping etc.
         */
        #[OneToMany("uid", [AccountCookie::class, "accountUid"])]
        public $cookies;

        /**
         * A helper that will initialise values right after the constructor,
         * useful for object initialiser without rewriting the constructor.
         */
        #[Initialiser("uid")]
        public function initialiseUID(): string {
            return \Hex::encode(openssl_random_pseudo_bytes(16));
        }
    }
}

?>