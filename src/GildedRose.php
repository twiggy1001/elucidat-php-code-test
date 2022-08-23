<?php

namespace App;

class GildedRose
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItem($which = null)
    {
        return ($which === null
            ? $this->items
            : $this->items[$which]
        );
    }

    public function nextDay()
    {
        $maxStandardQuality = 50;

        foreach ($this->items as $item) {
            //Don't change quality of legendary item
            if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
                if ($item->quality > $maxStandardQuality) {
                    $item->quality = $maxStandardQuality;
                }

                if ($item->name === 'Conjured Mana Cake') {
                    if ($item->quality > 0) {
                        $item->quality = $item->quality - 2;
                    }
                } elseif (!in_array($item->name, ['Aged Brie', 'Backstage passes to a TAFKAL80ETC concert'])) {
                    if ($item->quality > 0) {
                        $item->quality--;
                    }
                } else {
                    if ($item->quality < $maxStandardQuality) {
                        $item->quality++;
                        if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                            if ($item->sellIn < 11) {
                                if ($item->quality < $maxStandardQuality) {
                                    $item->quality++;
                                }
                            }
                            if ($item->sellIn < 6) {
                                if ($item->quality < $maxStandardQuality) {
                                    $item->quality++;
                                }
                            }
                        }
                    }
                }

                $item->sellIn--;

                if ($item->sellIn < 0) {
                    if ($item->name !== 'Aged Brie') {
                        if ($item->name === 'Conjured Mana Cake') {
                            if ($item->quality > 0) {
                                $item->quality = $item->quality - 2;
                            }
                        } elseif ($item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
                            if ($item->quality > 0) {
                                $item->quality--;
                            }
                        } else {
                            $item->quality = 0;
                        }
                    } else {
                        if ($item->quality < $maxStandardQuality) {
                            $item->quality++;
                        }
                    }
                }

                if ($item->quality < 0) {
                    $item->quality = 0;
                }
            }
        }
    }
}
