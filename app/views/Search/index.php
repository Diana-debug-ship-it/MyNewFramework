<?php
/** @var $this \wfm\View */
/** @var $products array */
/** @var $total int */
/** @var $pagination object */
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrump-item"><a href="<?= base_url() ?>"></a></li>
            <li class="breadcrump-item"><?php ___('tpl_search_title'); ?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?php __('tpl_search_title'); ?></h3>

            <h4></b><?= __('tpl_search_query') .h($s) ?></h4>

            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php $this->getPart('parts/products_loop', compact('products')); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <p><?= count($products) ?> <?php __('tpl_total_pagination'); ?> <?= $total ?> </p>
                            <?php if ($pagination->countPages > 1): ?>
                                <?= $pagination ?>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php else: ?>
                    <p><?php __('tpl_search_not_found'); ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
