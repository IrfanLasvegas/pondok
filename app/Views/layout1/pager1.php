<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation"  class="float-right">
    <ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>

        <li class="page-item">
            <a class="page-link" href="<?= $pager->getFirst() ?>"><i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i></a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getPreviousPage() ?>"><i class="fas fa-chevron-left"></i></a>
        </li>


    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
        <?php 
            if($link['active']){
                ?>
                    <li class="page-item active"><a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?> <span class="sr-only">(current)</span></a></li>
                <?php
            }else{
                ?>
                    <li class="page-item"><a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?> <span class="sr-only">(current)</span></a></li>
                <?php
            }
        ?>

    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <!-- <li>
            <a href="<?= $pager->getNextPage() ?>" aria-label="<?= lang('Pager.next') ?>">
                <span aria-hidden="true"><?= lang('Pager.next') ?></span>
            </a>
        </li> -->
        <!-- <li>
            <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
        </li> -->

        <li class="page-item">
            <a class="page-link" href="<?= $pager->getNextPage() ?>"><i class="fas fa-chevron-right"></i></a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getLast() ?>"><i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></a>
        </li>
    <?php endif ?>
    </ul>
</nav>

<!-- <nav class="d-inline-block">
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav> -->