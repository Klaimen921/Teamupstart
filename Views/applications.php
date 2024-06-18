<?php
require_once './partials/site/header.php';
?>
<main class="d-flex flex-column gap-40">
    <section class="profile-section">
        <div class="container">
            <div class="profile-section__content profile-content d-flex flex-column gap-40">
                <div class="user-list d-flex flex-column gap-12">
                    <?php foreach ($result as $res): ?>
                        <div class="user-item surface-white padding-40 border-radius-12">
                            <div class="user-item__header user-header d-flex justify-content-between align-items-center">
                                <div class="user-header__info d-flex align-items-center gap-12">
                                    <h4>Заявка в команду від <?= $res["user_name_1"] ?></h4>
                                </div>
                                <div class="d-flex gap-8">
                                    <?php if ($res['status'] == 2): ?>
                                        <form action="/change_invite_status" method="post" class="d-flex gap-12">
                                            <input type="hidden" name="id_team" value="<?= $res["id_team"] ?>">
                                            <select name="status" id="" required>
                                                <option disabled selected>Статус</option>
                                                <option value="1">Прийняти заявку в команду</option>
                                                <option value="-1">Відмовитися</option>
                                            </select>
                                            <button
                                                class="btn-form surface-action text-on-action padding-8">Підтвердити</button>
                                        </form>
                                    <?php elseif ($res['status'] == 1): ?>
                                        <p>Application accepted</p>
                                    <?php elseif ($res['status'] == -1): ?>
                                        <p>The application is rejected</p>
                                    <?php endif; ?>

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