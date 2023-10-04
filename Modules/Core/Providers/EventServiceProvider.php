<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Core\Events\EmailCustomEvent;
use Modules\Core\Events\FeedNotificacao;
use Modules\Core\Events\NotificacaoCustomEvent;
use Modules\Core\Events\NotificacaoEvent;
use Modules\Core\Events\UsuarioCadastrado;
use Modules\Core\Listeners\EmailDeCadastro;
use Modules\Core\Listeners\EnviarEmailCustom;
use Modules\Core\Listeners\EnviarFeedNotificacao;
use Modules\Core\Listeners\FireBaseCustomNotificacaoListener;
use Modules\Core\Listeners\FireBaseNotificacaoListener;
use Modules\Core\Listeners\RegraDeAcesso;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        FeedNotificacao::class =>[
            EnviarFeedNotificacao::class
        ],
        UsuarioCadastrado::class => [
            EmailDeCadastro::class,
            RegraDeAcesso::class,
        ],
        NotificacaoEvent::class => [
            FireBaseNotificacaoListener::class
        ],
        NotificacaoCustomEvent::class => [
            FireBaseCustomNotificacaoListener::class
        ],
        EmailCustomEvent::class => [
            EnviarEmailCustom::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

}
