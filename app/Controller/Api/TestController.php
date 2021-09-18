<?php

namespace App\Controller\Api {
    use Slate\Http\HttpRequest;
    use Slate\Http\HttpResponse;
    use App\Controller\RestController;
    use App\Entity\Account;
    use App\Entity\AccountCookie;
    use Slate\Mvc\Attribute\Route;

    class TestController extends RestController {
        #[Route(methods: "get")]
        public function ping(HttpRequest $request, HttpResponse $response): string {
            return "pong";
        }

        #[Route]
        public function entities(HttpRequest $request, HttpResponse $response): array {
            // It is required that you use this method of specifying columns
            // as, due to the makeup of the final query, it would be ambiguous otherwise.
            $account = Account::first(Account::username(), "admin");

            $accounts = Account::all();

            // Use the 'plan' static method to describe your query
            // You can only specify relationships at the moment.
            $accountsToCookies = Account::plan([
                "cookies" => [
                    // Special variable are injected using "@{name}"
                    // Here, you can depth limit. However, this
                    // comes with a performance hit without where
                    // queries. ~5-10ms for moderate table sizes in the
                    // thousands.
                    "@offset" => 0,
                    "@limit" => 2,

                    // You can order by child relationships by the options
                    // @orderBy(Asc|Desc)
                    // OR
                    // @orderBy and @orderDirection 
                    // You can play around and see the results
                    "@orderByAsc" => AccountCookie::id(),
                    // "@orderByDesc" => AccountCookie::id(),
                    
                    // This will determine the join type.
                    // Noted: this is only for this branch.
                    // ! = Inner Join
                    // ? = Left join
                    // It is advised to use the left join on
                    // the first branch as little as possible
                    // due to the implementation of depth limiting
                    // will impact performance.
                    "@flag" => "!"

                    // You specify where conditions exclusively to this branch
                    // using this option. Furthermore using this method
                    // should increases performance with left joins
                    // due to the implementation of depth limiting.
                    // "@where" => function() {}
                ]

            ])->get();


            // Use Entity::commit() to commit instances.
            // $account->commit();

            // Using ->toString to review a query (or multiple if having multiple branches)
            // @see Slate\Neat\EntityQuery for more details
            // echo $accountsToCookies->toString();

            return [
                // You will see on the output these two will have the same makeup as the next variable,
                // despite not specifying for cookies in the query plan, this is because all entity models
                // are stored centrally and passed back by reference.
                // This is to avoid conflicts on loading and committing etc.
                $account,
                $accounts,
                $accountsToCookies,
            ];
        }
    }
}

?>
