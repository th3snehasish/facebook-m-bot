<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

include 'routes_admin.php';

include 'routes_cron.php';

Route::auth();

Route::group(['middleware' => 'auth'], function () {

    require_once __DIR__ . '/routes_api.php';

    Route::get('/', [
        'uses' => 'ProjectsController@index',
        'as' => 'home',
        '__rp' => ['menu' => 'dashboard'],
    ]);

    Route::group(['prefix' => 'account', 'as' => 'account.'], function () {

        Route::get('/', [
            'uses' => 'AccountController@index',
            'as' => 'index',
        ]);

        Route::post('/update', [
            'uses' => 'AccountController@update',
            'as' => 'update',
        ]);

        Route::post('/password', [
            'uses' => 'AccountController@password',
            'as' => 'password',
        ]);

        Route::delete('/delete', [
            'uses' => 'AccountController@delete',
            'as' => 'delete',
        ]);

    });

    Route::group(['prefix' => 'projects', 'as' => 'projects.'], function () {

        Route::get('/', [
            'uses' => 'ProjectsController@index',
            'as' => 'index',
            '__rp' => ['menu' => 'dashboard'],
        ]);

        Route::get('/create', [
            'uses' => 'ProjectsController@create',
            'as' => 'create',
            '__rp' => ['menu' => 'dashboard'],
        ]);

        Route::post('/store', [
            'uses' => 'ProjectsController@store',
            'as' => 'store',
            '__rp' => ['menu' => 'dashboard'],
        ]);

        Route::group(['prefix' => '{project}', '__rp' => ['menu' => 'projects']], function () {

            Route::get('/', [
                'uses' => 'ProjectsController@show',
                'as' => 'show',
                '__rp' => ['submenu' => 'dashboard'],
            ]);

            Route::get('/settings', [
                'uses' => 'ProjectsController@settings',
                'as' => 'settings',
                '__rp' => ['submenu' => 'settings'],
            ]);

            Route::post('/update', [
                'uses' => 'ProjectsController@update',
                'as' => 'update',
            ]);

            Route::post('/update/thread', [
                'uses' => 'ProjectsController@updateThread',
                'as' => 'update.thread',
            ]);

            Route::delete('/delete', [
                'uses' => 'ProjectsController@delete',
                'as' => 'delete',
            ]);

            Route::post('/welcomeMessage', [
                'uses' => 'ProjectsController@setWelcomeMessage',
                'as' => 'welcomeMessage',
            ]);

            Route::group(['prefix' => 'messages', 'as' => 'messages.', '__rp' => ['submenu' => 'messages']], function () {

                Route::get('/', [
                    'uses' => 'MassMessagesController@index',
                    'as' => 'index',
                ]);

                Route::group(['prefix' => '{massMessage}'], function () {

                    Route::get('/', [
                        'uses' => 'MassMessagesController@show',
                        'as' => 'show',
                    ]);

                });

            });

            Route::group(['prefix' => 'responds', 'as' => 'responds.', '__rp' => ['submenu' => 'responds']], function () {

                Route::get('/', [
                    'uses' => 'RespondsController@index',
                    'as' => 'index',
                ]);

                Route::get('/create', [
                    'uses' => 'RespondsController@create',
                    'as' => 'create',
                ]);

                Route::group(['prefix' => '{respond}'], function () {

                    Route::group(['prefix' => 'edit'], function () {

                        Route::get('/', [
                            'uses' => 'RespondsController@edit',
                            'as' => 'edit',
                        ]);

                        Route::group(['prefix' => 'taxonomy', 'as' => 'edit.taxonomies.'], function () {

                            Route::get('new/{type?}/{parent?}', [
                                'uses' => 'TaxonomiesController@create',
                                'as' => 'create',
                            ]);

                            Route::post('store', [
                                'uses' => 'TaxonomiesController@store',
                                'as' => 'store',
                            ]);

                            Route::group(['prefix' => '{taxonomy}'], function () {

                                Route::get('/edit', [
                                    'uses' => 'TaxonomiesController@edit',
                                    'as' => 'edit',
                                ]);

                                Route::post('/update', [
                                    'uses' => 'TaxonomiesController@update',
                                    'as' => 'update',
                                ]);

                                Route::get('/move/up', [
                                    'uses' => 'TaxonomiesController@moveUp',
                                    'as' => 'move.up',
                                ]);

                                Route::get('/move/down', [
                                    'uses' => 'TaxonomiesController@moveDown',
                                    'as' => 'move.down',
                                ]);

                                Route::get('/delete', [
                                    'uses' => 'TaxonomiesController@delete',
                                    'as' => 'delete',
                                ]);

                            });

                        });

                    });

                    Route::post('/update', [
                        'uses' => 'RespondsController@update',
                        'as' => 'update',
                    ]);

                    Route::delete('/delete', [
                        'uses' => 'RespondsController@delete',
                        'as' => 'delete',
                    ]);

                });

            });

            Route::group(['prefix' => 'recipients', 'as' => 'recipients.'], function () {

                Route::get('/', [
                    'uses' => 'RecipientsController@index',
                    'as' => 'index',
                    '__rp' => ['submenu' => 'recipients'],
                ]);

                Route::group(['prefix' => 'variables', 'as' => 'variables.', '__rp' => ['submenu' => 'recipients_variables']], function () {

                    Route::get('/', [
                        'uses' => 'RecipientsVariablesController@index',
                        'as' => 'index',
                    ]);

                    Route::get('/create', [
                        'uses' => 'RecipientsVariablesController@create',
                        'as' => 'create',
                    ]);

                    Route::post('/store', [
                        'uses' => 'RecipientsVariablesController@store',
                        'as' => 'store',
                    ]);

                    Route::group(['prefix' => '{recipientVariable}'], function () {

                        Route::get('/edit', [
                            'uses' => 'RecipientsVariablesController@edit',
                            'as' => 'edit',
                        ]);

                        Route::post('/update', [
                            'uses' => 'RecipientsVariablesController@update',
                            'as' => 'update',
                        ]);

                        Route::delete('/delete', [
                            'uses' => 'RecipientsVariablesController@delete',
                            'as' => 'delete',
                        ]);

                    });

                });

                Route::group(['prefix' => '{recipient}', '__rp' => ['submenu' => 'recipients']], function () {

                    Route::get('/', [
                        'uses' => 'RecipientsController@show',
                        'as' => 'show',
                    ]);

                    Route::get('/edit', [
                        'uses' => 'RecipientsController@edit',
                        'as' => 'edit',
                    ]);

                    Route::post('/update', [
                        'uses' => 'RecipientsController@update',
                        'as' => 'update',
                    ]);

                });

            });

            Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {

                Route::group(['prefix' => 'channels', 'as' => 'channels.', '__rp' => ['submenu' => 'subscriptions_channels']], function () {

                    Route::get('/', [
                        'uses' => 'Subscriptions\ChannelsController@index',
                        'as' => 'index',
                    ]);

                    Route::group(['prefix' => '{subscriptionChannel}'], function () {

                        Route::get('/', [
                            'uses' => 'Subscriptions\ChannelsController@show',
                            'as' => 'show',
                        ]);

                        Route::delete('/delete', [
                            'uses' => 'Subscriptions\ChannelsController@delete',
                            'as' => 'delete',
                        ]);

                        Route::group(['prefix' => 'broadcasts', 'as' => 'broadcasts.'], function () {

                            Route::group(['prefix' => '{channelBroadcast}'], function () {

                                Route::get('/', [
                                    'uses' => 'Subscriptions\BroadcastsController@show',
                                    'as' => 'show',
                                ]);

                            });

                        });

                    });

                });

            });

        });

    });
});
