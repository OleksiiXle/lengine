<?php

namespace App\Widgets;

use App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /*
         * Регистрируется дирректива для шаблонизатора Blade
         * Пример обращаения к виджету: @widget('menu')
         * Можно передать параметры в виджет:
         * @widget('menu', [$data1,$data2...])
         */
        Blade::directive('widget', function ($name) {
            return "<?php echo app('widget')->show($name); ?>";
        });
        /*
         * Регистрируется (добавляем) каталог для хранения шаблонов виджетов
         * app\Widgets\view
         */
        $this->loadViewsFrom(app_path() .'/Widgets/view', 'Widgets');
        $this->loadRoutesFrom(__DIR__ . '/Routes/routes.php');

    }

    public function register()
    {

    }
}