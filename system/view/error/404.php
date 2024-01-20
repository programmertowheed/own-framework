<!DOCTYPE html>
<html lang="en">
<head>
    <meta charSet="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-zinc-700 dark:text-zinc-300 relative w-full min-h-screen bg-no-repeat duration-300">

<section>
    <div class="bg-black text-white">
        <div class="flex h-screen">
            <div class="m-auto text-center">
                <div class="w-full flex justify-center py-4 px-10"><img alt="404" loading="lazy" width="631"
                                                                        height="379" decoding="async" data-nimg="1"
                                                                        style="color:transparent"
                                                                        src="https://cdn.programmertowheed.com/assets/images/404.svg"/>
                </div>
                <p class="text-sm md:text-base text-red-600 p-2 mb-4"><?= isset($msg) ? $msg : "" ?></p>
                <a href="<?= url("/") ?>"
                   class="bg-transparent hover:bg-yellow-300 text-yellow-300 hover:text-white rounded shadow hover:shadow-lg py-2 px-4 border border-yellow-300 hover:border-transparent">Retry</a>
            </div>
        </div>
    </div>
</section>
</body>
</html>