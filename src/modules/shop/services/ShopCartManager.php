<?php
namespace wajox\yii2base\modules\shop\services;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\helpers\GoodsHelper;
use wajox\yii2base\components\base\Object;

class ShopCartManager extends Object
{
    protected $user = null;
    protected $items = [];
    protected $saveMode = true;
    protected $goods = [];
    protected $cart = [];
    protected $statusId;

    const STATUS_ID_ACTUAL = 100;
    const STATUS_ID_CHANGED = 200;

    const SHOP_CART_PARAM = '__shop_cart';

    public function __construct($user, bool $saveMode = true)
    {
        $this->setActual()
             ->setUser($user)
             ->loadFromSession()
             ->saveToSession();
    }

    public function setSaveMode(bool $saveMode): ShopCartManager
    {
        $this->saveMode = $saveMode;

        return $this;
    }

    public function getSaveMode(): bool
    {
        return $this->saveMode;
    }

    public function setUser($user): ShopCartManager
    {
        $this->user = $user;

        return $this;
    }

    public function setGoods(array $goods): ShopCartManager
    {
        $this->goods = $goods;

        return $this;
    }

    public function getGoods(): array
    {
        if (sizeof($this->goods) < sizeof($this->items)) {
            $this->loadGoods();
        }

        return $this->goods;
    }

    protected function setCart(array $cart): ShopCartManager
    {
        $this->cart = $cart;

        return $this;
    }

    public function getCart(): array
    {
        if (!$this->isActual()) {
            $this->getCartByItems($this->items);
        }

        return $this->cart;
    }

    public function loadGoods($items = null): ShopCartManager
    {
        $items = $items == null ? $this->items : $items;
        $ids = array_keys($items);
        $goods = [];

        if (sizeof($ids) > 0) {
            $goods = $this
                ->getRepository()
                ->find(Good::className())
                ->byIds($ids)
                ->all();
        }

        $this->setGoods($goods)
             ->setChanged();

        return $this;
    }

    public function getCartByItems(array $items): ShopCartManager
    {
        return $this
            ->loadGoods($items)
            ->computeCart($items);
    }

    public function getCount(int $goodId): int
    {
        if (isset($this->items[$goodId])) {
            return $this->items[$goodId];
        }

        return 0;
    }

    public function computeCart(array $items): ShopCartManager
    {
        $cartItems = [];
        $totalCount = 0;
        $sum = 0.0;
        $deliverySum = 0.0;
        $totalSum = 0.0;

        foreach ($this->getGoods() as $good) {
            $count  = intval($this->getCount($good->id));
            $prices = $this->computePrices($good);

            $total = $prices['sum'] * $count;
            $deliveryPriceSum = $prices['delivery'] * $count;
            $priceSum = $prices['price'] * $count;

            $cartItems[$good->id] = [
                    'model' => $good,
                    'count' => $count,
                    'deliveryPrice' => $prices['delivery'],
                    'price' => $prices['price'],
                    'sum' => $prices['sum'],
                    'total' => $total,
                ];

            $totalCount  += $count;
            $totalSum    += $total;
            $deliverySum += $deliveryPriceSum;
            $sum         += $priceSum;
        }

        $cart['items']       = $cartItems;
        $cart['totalCount']  = $totalCount;
        $cart['tatolSum']    = $totalSum;
        $cart['sum']         = $sum;
        $cart['deliverySum'] = $deliverySum;

        $this->setCart($cart)->setActual();

        return $this;
    }

    public function getCartItems(): array
    {
        return $this->getCart()['items'];
    }

    public function getDeliverySum()
    {
        return $this->getCart()['deliverySum'];
    }

    public function getSum()
    {
        return $this->getCart()['sum'];
    }

    public function getTotalSum()
    {
        return $this->getCart()['totalSum'];
    }

    public function clearIds(array $ids): array
    {
        $ids = array_map($ids, 'intval');

        return $ids;
    }

    public function getCartJson(): string
    {
        $items = [];

        foreach ($this->items as $id => $count) {
            $items[] = [
                    'id' => $id,
                    'count' => $count,
                ];
        }

        return json_encode(['items' => $items]);
    }

    public function parseCartJson(string $json): ShopCartManager
    {
        $this->dropItems();

        $data = json_decode($json, true);

        foreach ($data['items'] as $item) {
            $this->addItem(intval($item['id']), intval($item['count']));
        }

        return $this;
    }

    public function isItemExists(int $itemId): bool
    {
        return (isset($this->items[$itemId]) && $this->items[$itemId] > 0);
    }

    public function dropItems(): ShopCartManager
    {
        $this->items = [];

        $this->setChanged()
             ->saveToSession();

        return $this;
    }

    public function addItem(int $itemId, int $count = 1): ShopCartManager
    {
        if ($count < 1) {
            return $this->removeItem($itemId);
        }

        $this->items[$itemId] = $count;

        $this->setChanged()
             ->saveToSession();

        return $this;
    }

    public function removeItem(int $itemId): ShopCartManager
    {
        $this->items[$itemId] = null;
        unset($this->items[$itemId]);

        $this->setChanged()
             ->saveToSession();

        return $this;
    }

    protected function loadFromSession(): ShopCartManager
    {
        if ($this->getSaveMode() == false) {
            return $this;
        }

        $this->items = [];
        $session = $this->getApp()->session;
        if (isset($session[self::SHOP_CART_PARAM])) {
            $this->items = json_decode($session[self::SHOP_CART_PARAM], true);
        }

        $this->setChanged();

        return $this;
    }

    protected function saveToSession(): ShopCartManager
    {
        if ($this->getSaveMode() == false) {
            return $this;
        }

        $items = json_encode($this->items);
        
        $this
            ->getApp()
            ->session
            ->set(
                self::SHOP_CART_PARAM,
                $items
            );

        return $this;
    }

    protected function isActual(): bool
    {
        return $this->statusId == self::STATUS_ID_ACTUAL;
    }

    protected function setActual(): ShopCartManager
    {
        $this->statusId = self::STATUS_ID_ACTUAL;

        return $this;
    }

    protected function setChanged(): ShopCartManager
    {
        $this->statusId = self::STATUS_ID_CHANGED;

        return $this;
    }

    protected function computePrices($good): array
    {
        $originalPrice = $good->sum;
        $deliveryPrice = GoodsHelper::getDeliveryPrice($good);
        $price = GoodsHelper::getPartnerPrice(
            $good,
            $this->getApp()->visitor->partner
        );

        return [
            'sum' => $deliveryPrice + $price,
            'price' => $price,
            'delivery' => $deliveryPrice,
        ];
    }
}
