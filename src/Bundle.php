<?php

namespace panlatent\craft\actions\bundle;

use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use yii\base\Event;

final class Bundle
{
    public static function actions(): array
    {
        return [
            Closure::class,
            Console::class,
            CraftConsole::class,
            HttpRequest::class,
            SendEmail::class,
        ];
    }

    public static function register(): void
    {
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, static function(RegisterTemplateRootsEvent $event) {
            $event->roots['actions/bundle'] = __DIR__ . '/templates';
        });
    }
}