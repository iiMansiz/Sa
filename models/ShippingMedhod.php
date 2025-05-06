<?php
require_once 'core/Model.php';

class ShippingMethod extends Model {
    protected $table = 'shipping_methods';

    public function getActiveShippingMethods() {
        return $this->where('status', true);
    }
}
?>
