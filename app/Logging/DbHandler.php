<?php

namespace App\Logging;

use Illuminate\Contracts\Support\Arrayable;
use Monolog\Handler\AbstractProcessingHandler;

class DbHandler extends AbstractProcessingHandler
{

    protected function write(array $record): void
    {
        $logRecord = new LogRecord();

        $logRecord->message = data_get($record, 'message');

        $logRecord->level = data_get($record, 'level_name');

        $object = data_get($record, 'context.object');

        if (is_object($object)) {
            $logRecord->object_id = data_get($object, 'id');

            $logRecord->object_class = get_class($object);

            if ($object instanceof Arrayable) {
                $logRecord->object_state = $object->toArray();
            } else {
                $logRecord->object_state = (array)$object;
            }


        }

//        dump($record);

        $logRecord->data = data_get($record, 'context.data');

        $logRecord->save();
    }
}