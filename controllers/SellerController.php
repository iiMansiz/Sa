<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Product.php';
require_once 'models/Order.php';
require_once 'models/Category.php';


class SellerController extends Controller {
    // ... (constructor dan metode lain)

    public function addProduct() {
        $categories = $this->categoryModel->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ... (data produk dasar)

            if ($this->productModel->insert($data)) {
                $productId = $this->db->getInstance()->insert_id;

                // Handle gambar utama (upload file)
                if (!empty($_FILES['gambar']['name'])) {
                    $uploadDir = 'assets/uploads/'; // Pastikan direktori ini writable
                    $gambarName = basename($_FILES['gambar']['name']);
                    $gambarPath = $uploadDir . $gambarName;
                    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath)) {
                        $this->productModel->update($productId, ['gambar' => $gambarPath]);
                    }
                }

                // Handle variasi (jika ada) - ini bisa lebih kompleks tergantung implementasi UI
                if (isset($_POST['variations']) && is_array($_POST['variations'])) {
                    foreach ($_POST['variations'] as $variation) {
                        $variation['product_id'] = $productId;
                        $this->productModel->addProductVariation($variation);
                    }
                }

                $this->redirect('/seller/products');
            } else {
                // ... (error handling)
            }
        } else {
            $this->view('seller/product/add', ['categories' => $categories]);
        }
    }

    public function editProduct($id) {
        $product = $this->productModel->find($id);
        $categories = $this->categoryModel->getAllCategories();
        $images = $this->productModel->getProductImages($id);
        $variations = $this->productModel->getProductVariations($id);

        if (!$product || $product['seller_id'] !== Session::get('user_id')) {
            $this->redirect('/seller/products');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ... (data produk dasar update)

            // Handle upload gambar baru (jika ada)
            if (!empty($_FILES['gambar']['name'])) {
                // ... (proses upload seperti di addProduct)
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath)) {
                    // Hapus gambar lama jika ada
                    if ($product['gambar'] && file_exists($product['gambar'])) {
                        unlink($product['gambar']);
                    }
                    $data['gambar'] = $gambarPath;
                }
            }

            $this->productModel->update($id, $data);

            // Handle manajemen gambar tambahan (upload, delete)
            if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
                foreach ($_FILES['images']['name'] as $key => $name) {
                    if (!empty($name)) {
                        // ... (proses upload setiap gambar)
                        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $imagePath)) {
                            $this->productModel->addProductImage($id, $imagePath);
                        }
                    }
                }
            }
            if (isset($_POST['delete_image']) && is_array($_POST['delete_image'])) {
                foreach ($_POST['delete_image'] as $imageId) {
                    $image = $this->productModel->find('product_images', $imageId);
                    if ($image && file_exists($image['path'])) {
                        unlink($image['path']);
                    }
                    $this->productModel->deleteProductImage($imageId);
                }
            }

            // Handle manajemen variasi (add, edit, delete)
            if (isset($_POST['variations']) && is_array($_POST['variations'])) {
                foreach ($_POST['variations'] as $variationId => $variationData) {
                    if (strpos($variationId, 'new_') === 0) {
                        $variationData['product_id'] = $id;
                        $this->productModel->addProductVariation($variationData);
                    } else {
                        $this->productModel->updateProductVariation($variationId, $variationData);
                    }
                }
            }
            if (isset($_POST['delete_variation']) && is_array($_POST['delete_variation'])) {
                foreach ($_POST['delete_variation'] as $variationId) {
                    $this->productModel->deleteProductVariation($variationId);
                }
            }

            $this->redirect('/seller/products/edit/' . $id);
        } else {
            $this->view('seller/product/edit', ['product' => $product, 'categories' => $categories, 'images' => $images, 'variations' => $variations]);
        }
    }

    // ... (metode lain)
}
?>
