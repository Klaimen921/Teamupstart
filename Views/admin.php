<?php
require_once './partials/site/header.php';
?>
<main class="d-flex flex-column gap-40">

    <section class="top-section user">
        <div class="container">
            <div class="user-info__wrapper d-flex align-items-center justify-content-between">
                <div class="user-info d-flex align-items-center gap-24">
                    <div class="user-info__img d-flex justify-content-center align-items-center">
                        <h3 class="text-on-action text-uppercase"><?= mb_substr($users['name'], 0, 1) ?></h3>
                    </div>
                    <div class="user-info__details">
                        <h4 class="text-primary"><?= $users['name'] ?></h4>
                        <p class="text-primary caption-bold"><?= $users['email'] ?></p>
                    </div>
                </div>

                <a href="/logout" class="user__log-out btn-large text-secondary">
                    Log out
                </a>
            </div>

            <section class="list-resume d-flex flex-column gap-12">
                <?php foreach ($result as $res): ?>
                    <div class="item-resume padding-16  d-flex align-items-center justify-content-between border-radius-6">
                        <h5><?= $res['name'] ?></h5>
                        <a href="/info-user?id=<?= $res['user_id'] ?>">Деталі</a>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    </section>
</main>
</div>

<div class="alert-messages">
    <div class="alert-messages__item status-green border-radius-12 padding-24">
        <p class="text-on-action">Data updated successfully</p>
    </div>
</div>
<?php require_once './partials/site/footer.php'; ?>

<script src="./assets/js/script.js"></script>