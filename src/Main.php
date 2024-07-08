<?php

namespace FiraAja\Mace;

use FiraAja\Mace\item\ExtraItems;
use pocketmine\block\RuntimeBlockStateRegistry;
use pocketmine\crafting\ExactRecipeIngredient;
use pocketmine\crafting\ShapedRecipe;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\item\ItemTypeNames;
use pocketmine\data\bedrock\item\SavedItemData;
use pocketmine\inventory\CreativeInventory;
use pocketmine\item\StringToItemParser;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\world\format\io\GlobalBlockStateHandlers;
use pocketmine\world\format\io\GlobalItemDataHandlers;

class Main extends PluginBase
{

    protected function onEnable(): void
    {

        // MACE
        GlobalItemDataHandlers::getDeserializer()->map(ItemTypeNames::MACE, fn() => clone ExtraItems::MACE());
        GlobalItemDataHandlers::getSerializer()->map(ExtraItems::MACE(), fn() => new SavedItemData(ItemTypeNames::MACE));
        StringToItemParser::getInstance()->register(ItemTypeNames::MACE, fn() => clone ExtraItems::MACE());
        CreativeInventory::getInstance()->add(ExtraItems::MACE());

        // BREEZE ROD
        GlobalItemDataHandlers::getDeserializer()->map(ItemTypeNames::BREEZE_ROD, fn() => clone ExtraItems::BREEZE_ROD());
        GlobalItemDataHandlers::getSerializer()->map(ExtraItems::BREEZE_ROD(), fn() => new SavedItemData(ItemTypeNames::BREEZE_ROD));
        StringToItemParser::getInstance()->register(ItemTypeNames::BREEZE_ROD, fn() => clone ExtraItems::BREEZE_ROD());
        CreativeInventory::getInstance()->add(ExtraItems::BREEZE_ROD());

        // HEAVY CORE
        RuntimeBlockStateRegistry::getInstance()->register(ExtraItems::HEAVY_CORE());
        GlobalBlockStateHandlers::getDeserializer()->mapSimple(BlockTypeNames::HEAVY_CORE, fn() => clone ExtraItems::HEAVY_CORE());
        GlobalBlockStateHandlers::getSerializer()->mapSimple(ExtraItems::HEAVY_CORE(), BlockTypeNames::HEAVY_CORE);
        StringToItemParser::getInstance()->registerBlock(BlockTypeNames::HEAVY_CORE, fn() => clone ExtraItems::HEAVY_CORE());
        CreativeInventory::getInstance()->add(ExtraItems::HEAVY_CORE()->asItem());

        // REGISTER CRAFTING RECIPE
        $this->getScheduler()->scheduleDelayedTask(new ClosureTask(function (): void {
            $this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
                [
                    "A",
                    "B"
                ],
                [
                    "A" => new ExactRecipeIngredient(ExtraItems::HEAVY_CORE()->asItem()),
                    "B" => new ExactRecipeIngredient(ExtraItems::BREEZE_ROD())
                ],
                [ExtraItems::MACE()]
            ));
        }), 2);
    }
}