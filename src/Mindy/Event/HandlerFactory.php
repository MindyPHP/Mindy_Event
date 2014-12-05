<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 05/12/14 12:25
 */

namespace Mindy\Event;

use Aura\Signal\HandlerFactory as BaseHandlerFactory;

class HandlerFactory extends BaseHandlerFactory
{
    /**
     *
     * Creates and returns a new Handler object.
     *
     * @param array $params An array of key-value pairs corresponding to
     * Handler constructor params.
     *
     * @return Handler
     *
     */
    public function newInstance(array $params)
    {
        $params = array_merge($this->params, $params);
        return new Handler(
            $params['sender'],
            $params['signal'],
            $params['callback']
        );
    }
}
