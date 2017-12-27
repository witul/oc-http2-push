<?php namespace Infoadvisor\Push;

use Backend;
use System\Classes\PluginBase;
use Infoadvisor\Push\Classes\PushService;

/**
 * push Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'push',
            'description' => 'No description provided yet...',
            'author'      => 'infoadvisor',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('push', function() {
            return new PushService();
        });
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        $this->app['Illuminate\Contracts\Http\Kernel']
            ->pushMiddleware('Infoadvisor\Push\Classes\PushMiddleware');
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Infoadvisor\Push\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'infoadvisor.push.some_permission' => [
                'tab' => 'push',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'push' => [
                'label'       => 'push',
                'url'         => Backend::url('infoadvisor/push/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['infoadvisor.push.*'],
                'order'       => 500,
            ],
        ];
    }
}
