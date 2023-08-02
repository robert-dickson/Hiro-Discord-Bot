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

use Discord\Parts\Embed\Embed;
use hiro\database\Database;

/**
 * Money
 */
class Money extends Command
{
    /**
     * configure
     *
     * @return void
     */
    public function configure(): void
    {
        $this->command = "money";
        $this->description = "Displays your money.";
        $this->aliases = ["cash"];
        $this->category = "utility";
        $this->cooldown = 10 * 1000;
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
        global $database;
        $database = new Database();
        if (!$database->isConnected) {
            $msg->reply($language->getTranslator()->trans('database.notconnect'));
            return;
        }
        $user = $msg->mentions->first();
        if (!$user) $user = $msg->author;
        $user_money = $database->getUserMoney($database->getUserIdByDiscordId($user->id));
        if (!is_numeric($user_money)) {
            if (!$database->addUser([
                "discord_id" => $user->id
            ])) {
                $msg->reply($language->getTranslator()->trans('database.user.couldnt_added'));
                return;
            } else {
                $user_money = 0;
            }
        }

        $pronoun = $user->username;

        setlocale(LC_MONETARY, 'en_US');
        $user_money = number_format($user_money, 2, ',', '.');
        $msg->reply(
            sprintf(
                $language->getTranslator()->trans('commands.money.reply'),
                $pronoun,
                $user_money,
                "<a:hirocoinflip:1130395266105737256>"
            )
        );
        $database = NULL;
    }
}
