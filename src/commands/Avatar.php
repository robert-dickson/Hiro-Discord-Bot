<?php

/**
 * Copyright 2021 bariscodefx
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

use Discord\DiscordCommandClient;
use Discord\Parts\Embed\Embed;

/**
 * Avatar command class
 */
class Avatar
{
    
    /**
     * command category
     */
    private $category;
    
    /**
     * $client
     */
    private $discord;
    
    /**
     * __construct
     */
    public function __construct(DiscordCommandClient $client)
    {
        $this->discord = $client;
        $this->category = "fun";
        $client->registerCommand('avatar', function($msg, $args)
        {
            $user = $msg->mentions->first();
            if($user)
            {
                $avatar = $user->avatar;
            }else {
                $avatar = $msg->author->user->avatar;
            }
            if (strpos($avatar, 'a_') !== false){
                $avatar= str_replace('jpg', 'gif', $avatar);
            }
            $embed = new Embed($this->discord);
            $embed->setColor("#ff0000");
            $embed->setTitle("Avatar");
            $embed->setImage($avatar);
            $embed->setTimestamp();
            $msg->channel->sendEmbed($embed);
        }, [
            "aliases" => [
                "whoami"
            ],
            "description" => "Shows avatar"
        ]);
    }
    
    public function __get(string $name)
    {
        return $this->{$name};
    }
    
}
