<?php
/** @var $this \wfm\View
 * @var $products array
 */
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrump-item"><a href="<?= base_url() ?>"></a></li>
            <li class="breadcrump-item"><?php ___('wishlist_index_title'); ?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?php __('wishlist_index_title'); ?></h3>

            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php $this->getPart('parts/products_loop', compact('products')); ?>
                <?php else: ?>
                    <p><?php __('wishlist_index_not_found'); ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
