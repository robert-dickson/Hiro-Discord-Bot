<?php

/**
 * Copyright 2023 bariscodefx.
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

namespace hiro\commands;

/**
 * Kill.
 */
class Kill extends Command
{
    /**
     * configure.
     */
    public function configure(): void
    {
        $this->command = 'kill';
        $this->description = 'Kills bot **ONLY FOR AUTHOR**';
        $this->aliases = array('sb', 'stopbot');
        $this->category = 'author';
    }

    /**
     * handle.
     *
     * @param [type] $msg
     * @param [type] $args
     */
    public function handle($msg, $args): void
    {
        if ($msg->author->id != $_ENV['AUTHOR']) {
            return;
        }

        $msg->reply('hara-kiri')->then(
            function () {
                exit(0);
            }
        );
    }
}
