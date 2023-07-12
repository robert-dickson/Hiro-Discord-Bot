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

/**
 * ServerAvatar
 */
class ServerAvatar extends Command
{
    /**
     * configure
     *
     * @return void
     */
    public function configure(): void
    {
        $this->command = "serveravatar";
        $this->description = "Returns server pfp.";
        $this->aliases = ["server_avatar", "server-avatar", "svavatar", "savatar", "getserveravatar"];
        $this->category = "bot";
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
        if (!@$msg->channel->guild) {
            $msg->reply("You can only use in a guild!");
            return;
        }
        $embed = new Embed($this->discord);
        $embed->setColor("#ff0000");
        $embed->setDescription($msg->channel->guild->getUpdatableAttributes()['name'] . "'s Avatar");
        $embed->setImage($msg->channel->guild->getIconAttribute("png", 1024));
        $embed->setTimestamp();
        $msg->channel->sendEmbed($embed);
    }
}
