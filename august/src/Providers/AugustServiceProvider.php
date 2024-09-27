<?php

namespace Package\August\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Package\August\Http\Middleware\CheckUserRole;

class AugustServiceProvider extends ServiceProvider {

    /**
    * Register bindings in the container.
    */
    public function register() {
        //
    }

    public function boot(Router $router) {
        $router->aliasMiddleware('checkUserRole', CheckUserRole::class);

        $modulePath = __DIR__.'/../../';
        $moduleName = 'August';

        // boot route
        if (File::exists($modulePath."routes/routes.php")) {
            $this->loadRoutesFrom($modulePath."/routes/routes.php");
        }

        // boot views
        if (File::exists($modulePath . "resources/views")) {
            $this->loadViewsFrom($modulePath . "resources/views", $moduleName);
        }

        // boot languages
        if (File::exists($modulePath . "resources/lang")) {
            $this->loadTranslationsFrom($modulePath . "resources/lang", $moduleName);
        }

        // boot all helpers
        if (File::exists($modulePath . "helpers")) {
            // Lây thông tin file tại thư mục helpers
            $helper_dir = File::allFiles($modulePath . "helpers");
            
            // Khai báo helpers
            foreach ($helper_dir as $key => $value) {
                $file = $value->getPathName();
                require $file;
            }
        }

        // phpspreadsheet
        require $modulePath.'/phpoffice/autoload.php';


        // symlink assets
        $link = $_SERVER["DOCUMENT_ROOT"] . "/public/assets-august";
        $target = $_SERVER["DOCUMENT_ROOT"] . "/packages/august/resources/assets-august";

        if (!is_link($link)) {
            // unlink($link);
            // symlink($target, $link);
        }

        // symlink storage
        $link = $_SERVER["DOCUMENT_ROOT"] . "/public/storage";
        $target = $_SERVER["DOCUMENT_ROOT"] . "/storage/app/public";

        if (!is_link($link)) {
            // unlink($link);
            // symlink($target, $link);
        }
    }
}
?>