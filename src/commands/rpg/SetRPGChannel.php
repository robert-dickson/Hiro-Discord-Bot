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

namespace hiro\commands;

use hiro\database\Database;

class SetRPGChannel extends Command
{
    /**
     * configure
     *
     * @return void
     */
    public function configure(): void
    {
        $this->command = "setrpgchannel";
        $this->description = "Sets RPG channel for the server.";
        $this->aliases = [];
        $this->category = "rpg";
    }

    /**
     * handle
     *
     * @param [type] $msg
     * @param [type] $args
     * @return void
     */
    public function handle($msg, $args): void
    {
        global $language;
        $database = new Database();
        if (!$database->isConnected) {
            $msg->channel->sendMessage($language->getTranslator()->trans('database.notconnect'));
            return;
        }

        if (!$msg->member->getPermissions()['manage_channels']) {
            $msg->reply($language->getTranslator()->trans('commands.setrpgchannel.no_perm'));
            return;
        }

        if (isset($args[0])) {
            preg_match('@<#([0-9]+)>@', $args[0], $result);
        }
        $channel = $result[1] ?? $msg->channel->id;

        if (!isset($msg->guild->channels[$channel])) {
            $msg->reply($language->getTranslator()->trans('commands.setrpgchannel.no_channel'));
            return;
        }

        if (!$database->setServerRPGChannel($database->getServerIdByDiscordId($msg->guild->id), $channel)) {
            $msg->reply($language->getTranslator()->trans('global.unknown_error'));
            return;
        }

        $msg->reply(sprintf($language->getTranslator()->trans('commands.setrpgchannel.success'), $channel));
    }
}
