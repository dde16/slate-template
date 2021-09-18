<head>
    <title><? echo env("mvc.title", [ "fallback" => "Title" ]); ?></title>

    <?php

    use App\Auxiliary\Vite;

    debug((new Vite())->toString("../vue/App.ts"));

    ?>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Icon -->
    <link rel="icon" type="image/svg" href="/image/brand/lettermark.svg"/>
</head>