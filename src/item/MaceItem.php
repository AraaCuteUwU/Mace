<?php

namespace FiraAja\Mace\item;

use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Tool;
use pocketmine\math\Vector3;

class MaceItem extends Tool
{

    public function getBlockToolType() : int{
        return BlockToolType::SWORD;
    }

    public function getMaxDurability() : int{
        return 250;
    }

    public function getAttackPoints() : int{
        return 5;
    }

    public function getBlockToolHarvestLevel() : int{
        return 1;
    }

    public function getMiningEfficiency(bool $isCorrectTool) : float{
        return parent::getMiningEfficiency($isCorrectTool) * 1.5;
    }

    public function getBaseMiningEfficiency() : float{
        return 10;
    }

    public function onDestroyBlock(Block $block, array &$returnedItems) : bool{
        if(!$block->getBreakInfo()->breaksInstantly()){
            return $this->applyDamage(2);
        }
        return false;
    }

    public function onAttackEntity(Entity $victim, array &$returnedItems) : bool{
        if($victim->getLastDamageCause()->getCause() == EntityDamageEvent::CAUSE_ENTITY_ATTACK){

            /** @var Entity $user */
            $user = $victim->getLastDamageCause()->getDamager();
            $height = $user->getFallDistance();

            if($height >= 2) {
                $damage = ($height - 1) * 5;
                $victim->setHealth($victim->getHealth() - $damage);

                $motion = $user->getMotion();
                $user->setMotion(new Vector3($motion->x, 0, $motion->z));

                $user->fallDistance = 0;
            }
        }

        $this->applyDamage(2);

        return true;
    }
}