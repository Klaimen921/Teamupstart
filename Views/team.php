<?php require_once './partials/site/header.php'; ?>
<main class="d-flex flex-column gap-40">
    <section class="profile-section">
        <div class="container">
            <div class="profile-section__content profile-content d-flex flex-column gap-40">
                <div class="user-list d-flex flex-column gap-12">
                    <h4>Team</h4>
                    <?php foreach ($result as $res): ?>
                        <div class="user-item surface-white padding-40 border-radius-12">
                            <div class="user-item__header user-header d-flex justify-content-between align-items-center">
                                <div class="user-header__info d-flex align-items-center gap-12">
                                    <img src="../assets/img/icon/star-active.svg" alt="star-active">
                                    <h4><?= $res['user_name_2'] ?></h4>
                                </div>
                                <div>
                                    <a href="/info-user?id=<?= $res['id_user_2'] ?>">Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>
</div>
<?php require_once './partials/site/footer.php'; ?>