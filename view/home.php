<!DOCTYPE html>
<html>
    <? if(file_exists(env("mvc.public.path") . "/dist/manifest.json")): ?>
        <? require "partial/head.php"; ?>

        <body>
            <div id="app" class="w-100 h-100"></div>
        </body>
    <? else: ?>
        <body>
            <p style="color: #DDD;">Vite has not compiled or is being compiled...</p>
        </body>
    <? endif; ?>
</html>