<?php
require_once 'core/Model.php';

class Category extends Model {
    protected $table = 'categories';

    public function getAllCategories() {
        return $this->all();
    }
}
?>
