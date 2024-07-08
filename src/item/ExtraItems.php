<?php

namespace FiraAja\Mace\item;

use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\BlockTypeInfo;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\ToolTier;
use pocketmine\utils\CloningRegistryTrait;

/**
 * @method static Item BREEZE_ROD()
 * @method static Block HEAVY_CORE()
 * @method static MaceItem MACE()
 */
class ExtraItems
{
    use CloningRegistryTrait;

    protected static function setup(): void
    {
        self::_registryRegister('breeze_rod', new Item(new ItemIdentifier(ItemTypeIds::newId()), "Breeze Rod"));
        self::_registryRegister('heavy_core', new Block(new BlockIdentifier(BlockTypeIds::newId()), "Heavy Core", new BlockTypeInfo(BlockBreakInfo::pickaxe(10, ToolTier::WOOD, 30))));
        self::_registryRegister('mace', new MaceItem(new ItemIdentifier(ItemTypeIds::newId()), 'Mace'));
    }
}