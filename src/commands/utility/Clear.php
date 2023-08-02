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
 * Clear
 */
class Clear extends Command
{
    /**
     * configure
     *
     * @return void
     */
    public function configure(): void
    {
        $this->command = "clear";
        $this->description = "Clears messages";
        $this->aliases = ["purge"];
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
        global $language;
        if (!$msg->member->getPermissions()["manage_messages"]) {
            $embed = new Embed($this->discord);
            $embed->setTitle($language->getTranslator()->trans('commands.clear.error'));
            $embed->setDescription($language->getTranslator()->trans('commands.clear.no_perm'));
            $embed->setColor("#ff000");
            $embed->setTimestamp();
            $msg->channel->sendEmbed($embed);
            return;
        }
        $limit = $args[0];
        if (!isset($limit)) {
            $embed = new Embed($this->discord);
            $embed->setTitle($language->getTranslator()->trans('commands.clear.error'));
            $embed->setDescription($language->getTranslator()->trans('commands.clear.no_amount'));
            $embed->setColor("#ff000");
            $embed->setTimestamp();
            $msg->channel->sendEmbed($embed);
            return;
        } else if (!is_numeric($limit)) {
            $embed = new Embed($this->discord);
            $embed->setTitle($language->getTranslator()->trans('commands.clear.error'));
            $embed->setDescription($language->getTranslator()->trans('commands.clear.no_numeric_arg'));
            $embed->setColor("#ff000");
            $embed->setTimestamp();
            $msg->channel->sendEmbed($embed);
            return;
        } else if ($limit < 1 || $limit > 100) {
            $embed = new Embed($this->discord);
            $embed->setTitle($language->getTranslator()->trans('commands.clear.error'));
            $embed->setDescription($language->getTranslator()->trans('commands.clear.limit'));
            $embed->setColor("#ff000");
            $embed->setTimestamp();
            $msg->channel->sendEmbed($embed);
            return;
        }
        $msg->channel->limitDelete($limit)->then(function() use ($msg, $limit, $language) {
            $embed = new Embed($this->discord);
            $embed->setTitle("Clear Command");
            $embed->setDescription(sprintf($language->getTranslator()->trans('commands.clear.deleted'), $limit));
            $embed->setColor("#5558E0");
            $embed->setTimestamp();
            $msg->channel->sendEmbed($embed)->then(function ($msg) {
                $this->discord->getLoop()->addTimer(3.0, function () use ($msg) {
                    $msg->delete();
                });
            });
        }, function (\Throwable $reason) use ($msg, $language) {
            $msg->reply($reason->getCode() === 50013 ? $language->getTranslator()->trans('commands.clear.no_bot_perm') : $language->getTranslator()->trans('global.unknown_error'));
        });
    }
}
