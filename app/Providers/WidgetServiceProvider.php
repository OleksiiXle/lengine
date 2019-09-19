<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App;
use Illuminate\Support\Facades\Blade;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Задаёт отложена ли загрузка провайдера.
     *
     * @var bool
     */
  //  protected $defer = true;

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
        $this->loadRoutesFrom(app_path() . '/Widgets/Routes/routes.php');

    }

    public function register()
    {
        App::singleton('widget', function(){
            return new \App\Widgets\Widget();
        });
        /*
    $this->app->bind('HelpSpot\API', function ($app) {
    return new HelpSpot\API($app->make('HttpClient'));

    $api = new HelpSpot\API(new HttpClient);
    $this->app->instance('HelpSpot\API', $api);
    });         */
    }
}