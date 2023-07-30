<?php

/**
 * Copyright 2023 bariscodefx
 *
 * This file part of project Hiro 016 Discord Bot.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace hiro\parts;

/**
 * ArgumentParser
 */
class ArgumentParser
{
    /** arguments */
    public $args;

    /**
     * __construct
     *
     * @param [type] $args
     */
    public function __construct($args)
    {
        $this->args = $args;
    }

    /**
     * getShardId
     *
     * @return void
     */
    public function getShardId()
    {
        if ($this->args) {
            $args = $this->args;

            if (in_array('--shard-id', $args)) {
                $key = array_search('--shard-id', $args);
                return $args[$key+1];
            }

            return (0 << 0);
        }
    }

    /**
     * getShardCount
     *
     * @return void
     */
    public function getShardCount()
    {
        if ($this->args) {
            $args = $this->args;

            if (in_array('--shard-count', $args)) {
                $key = array_search('--shard-count', $args);
                return $args[$key+1];
            }

            return (1 << 0);
        }
    }
}
