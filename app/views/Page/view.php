<?php
 /** @var $page array
  */
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrump-item"><a href="<?= base_url() ?>"></a></li>
            <li class="breadcrump-item"><?php echo $page['title'] ?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h1 class="section-title"><?php echo $page['title'] ?></h1>

            <?= $page['content'] ?>

        </div>

    </div>
</div>
