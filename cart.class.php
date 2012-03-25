<?
class Cart extends DB {
    private $uid = 0;

    public function Cart($uid) {
        $this->uid = $uid;
    }

    public function addItem($iid) {
        $chooseItem = "uid='" . $this->uid . "' && iid='" . $iid . "'";

        if (!DB::countregisters('products', "id='" . $iid . "'"))
            return;

        if (DB::countregisters('cart', $chooseItem)) { //verifica se já existe um item desse
            DB::update('cart', array('qnt' => DB::get('qnt', 'cart', $chooseItem) + 1), $chooseItem);
        } else { //se não tiver nenhum igual, adiciona
            DB::insert('cart', array('uid' => $this->uid, 'iid' => $iid, 'qnt' => 1));
        }
    }

    public function dropItem($iid) {
        $chooseItem = "uid='" . $this->uid . "' && iid='" . $iid . "'";
        if (DB::countregisters('cart', $chooseItem)) { //verifica se existe um item desse
            DB::delete('cart', $chooseItem);
        }
    }

    public function listProducts() {
        $products = array();
        foreach (DB::iterate('cart', "uid=" . $this->uid) as $product) {
            $products[] = array('id' => $product['id'], 'iid' => $product['iid'], 'qnt' => $product['qnt']);
        }
        return $products;
    }
}