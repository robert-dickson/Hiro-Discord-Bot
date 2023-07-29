<?php

/**
 * Copyright 2023 bariscodefx
 * 
 * This file is part of project Hiro 016 Discord Bot.
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

use Discord\Voice\VoiceClient;
use React\ChildProcess\Process;
use Discord\Builders\MessageBuilder;

class Loop extends Command
{
    public function configure(): void
    {
        $this->command = "loop";
        $this->description = "Enables or disables looping in music.";
        $this->aliases = [];
        $this->category = "music";
    }

    public function handle($msg, $args): void
    {
        global $voiceSettings;
	    $channel = $msg->member->getVoiceChannel();
	    $voiceClient = $this->discord->getVoiceClient($msg->guild_id);

        if (!$channel) {
            $msg->channel->sendMessage("You must be in a voice channel.");
            return;
        }

        if (!$voiceClient) {
            $msg->reply("Use the join command first.\n");
            return;
        }

        if ($voiceClient && $channel->id !== $voiceClient->getChannel()->id) {
            $msg->reply("You must be in the same channel with me.");
            return;
	    }

        $settings = @$voiceSettings[$msg->channel->guild_id];
        
	    if (!$settings)
	    {
		    $msg->reply("Voice options couldn't found.");
		    return;
	    }

        if ($settings->getLoopEnabled())
        {
            $settings->setLoopEnabled(false);
            $msg->reply("Loop is **disabled** now.");
        } else {
             $settings->setLoopEnabled(true);
            $msg->reply("Loop is **enabled** now.");
        }
    }
}
