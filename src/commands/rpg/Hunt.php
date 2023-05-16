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

use hiro\consts\RPG;
use hiro\database\Database;
use hiro\parts\generators\{GithubImageGenerator, MonsterGenerator};
use Discord\Parts\Embed\Embed;
use Discord\Builders\MessageBuilder;
use Discord\Builders\Components\{Button, ActionRow};
use Discord\Parts\Interactions\Interaction;

class Hunt extends Command
{
    /**
     * configure
     *
     * @return void
     */
    public function configure(): void
    {
        $this->command = "hunt";
        $this->description = "Hunting.";
        $this->aliases = ["hunting"];
        $this->category = "rpg";
    }

    /**
     * handle
     *
     * @param  [type] $msg
     * @param  [type] $args
     * @return void
     */
    public function handle($msg, $args): void
    {
        $database = new Database();
        if (!$database->isConnected) {
            $msg->channel->sendMessage("Couldn't connect to database.");
            return;
        }

        $embed = new Embed($this->discord);
        $embed->setTitle("Hunting");
        $embed->setDescription("Click to the button for starting hunting");
        $embed->setTimestamp();
        $msg->channel->sendMessage(
            MessageBuilder::new()
                ->addEmbed($embed)
                ->addComponent(
                    ActionRow::new()->addComponent(
                        Button::new(Button::STYLE_DANGER)
                            ->setLabel("Start Hunting")
                            ->setListener(
                                function (Interaction $interaction) {
                                    $generator = new MonsterGenerator();
                                    $monster = $generator->generateRandom();
                                    $embed = new Embed($this->discord);
                                    $embed
                                        ->setTitle("Hunting")
                                        ->setDescription($monster->getName() . " seen " . GithubImageGenerator::generate($monster->getName()))
                                        ->setImage(GithubImageGenerator::generate($monster->getName()))
                                        ->setTimestamp();
                                    $interaction->respondWithMessage(
                                        MessageBuilder::new()
                                            ->addComponent(
                                                ActionRow::new()->addComponent(
                                                    Button::new(Button::STYLE_DANGER)->setLabel("Attack")
                                                )
                                            )
                                            ->addEmbed($embed),
                                        true
                                    );
                                },
                                $this->discord
                            )
                    )
                )
        );
    }
}
