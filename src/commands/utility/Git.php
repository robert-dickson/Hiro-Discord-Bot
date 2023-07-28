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
 * Git
 */
class Git extends Command
{
    /**
     * configure
     *
     * @return void
     */
    public function configure(): void
    {
        $this->command = "git";
        $this->description = "URL of bot's source code.";
        $this->aliases = ["source","opensource","open-source","github"];
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
        $embed = new Embed($this->discord);
        $embed->setColor("#ff0000");
        $embed->setTitle("Git (Github)");
        $embed->setURL("https://github.com/hiro-team/hiro-bot.git");
        $embed->setDescription("I'm open source!\nClick to go to the link.");
        $embed->setTimestamp();
        $msg->channel->sendEmbed($embed);
    }
    
}
