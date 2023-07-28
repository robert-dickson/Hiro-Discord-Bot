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
 * Daily
 */
class Daily extends Command
{
    /**
     * configure
     *
     * @return void
     */
    public function configure(): void
    {
        $this->command = "daily";
        $this->description = "Daily moneys.";
        $this->aliases = [];
        $this->category = "utility";
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
        $database = new Database();
        if (!$database->isConnected) {
            $msg->reply("Couldn't connect to database.");
            return;
        }
        $user_money = $database->getUserMoney($database->getUserIdByDiscordId($msg->member->id));
        $last_daily = $database->getLastDailyForUser($database->getUserIdByDiscordId($msg->member->id));

        if (time() - $last_daily < 86400) {
            $msg->reply('You can use this command in <t:' . ($last_daily + 86400) . ':R>.');
            return;
        }
        
        if (!is_numeric($user_money)) {
            if (!$database->addUser([
                "discord_id" => $msg->member->id
            ])) {
                $msg->reply("You are couldn't added to database.");
                return;
            } else {
                $user_money = 0;
            }
        }
        setlocale(LC_MONETARY, 'en_US');
        $daily = $database->daily($database->getUserIdByDiscordId($msg->member->id));
        if ($daily) {
            $msg->reply("You gained " . number_format($daily, 2, ',', '.') . " <:hirocoin:1130392530677157898> coins.");
        } else {
            $msg->reply("Couldn't give daily");
        }
        $database = NULL;
    }
}
