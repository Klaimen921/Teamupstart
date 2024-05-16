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
                <div class="d-flex align-items-center gap-12">
                    <?php if ($id != $_SESSION['user_id']): ?>
                        <a href="/chat?id=<?= $id ?>">
                            <button class="padding-bottom btn-form btn-large surface-action text-on-action">Написати
                                користувачу</button>
                        </a>
                    <?php endif; ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <form action="/change_status_resume" method="post">
                            <input type="hidden" placeholder="" value="<?= $usersData['id'] ?>" name="id_resume" required>

                            <select name="status" id="">
                                <option selected disabled>Виберіть
                                </option>
                                <option value="2" <?php echo ($usersData['status'] == 2) ? 'selected' : '' ?>>Опублікувати
                                </option>
                                <option value="1" <?php echo ($usersData['status'] == 1) ? 'selected' : '' ?>>Відправити на
                                    доопрацювання</option>
                            </select>

                            <button
                                class="btn-form padding-ml-8 text-on-action btn-large surface-action">Підтвердити</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>

    <section class="profile-section">
        <div class="container">
            <div class="profile-section__content profile-content d-flex flex-column gap-40">
                <div class="profile-content__edit profile-edit d-flex flex-column gap-16">
                    <div class="profile-edit__header d-flex align-items-center gap-16">
                        <img src="../assets/img/icon/edit.svg" alt="edit__icon">
                        <h5 class="text-primary">User profile</h5>
                    </div>

                    <div class="d-flex flex-column gap-40">
                        <div class="form-input__list d-grid profile-edit__form gap-16">
                            <div class="form-fields__item d-flex flex-column gap-4">
                                <p class="fields-item__title  navigation-label text-primary">Adress
                                </p>
                                <div class="form-fields__input surface-white">
                                    <input class="body-m-regular text-primary border-grey" type="text"
                                        placeholder="San Francisco, CA 94101" name="adress"
                                        value="<?= $usersData['adress'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-fields__item d-flex flex-column gap-4">
                                <p class="fields-item__title  navigation-label text-primary">Education</p>
                                <div class="form-fields__input surface-white">
                                    <input class="body-m-regular text-primary border-grey" type="text"
                                        placeholder="San Francisco, CA 94101" name="education"
                                        value="<?= $usersData['education'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-fields__item d-flex flex-column gap-4">
                                <p class="fields-item__title  navigation-label text-primary">Languages known
                                </p>
                                <div class="form-fields__input surface-white">
                                    <input class="body-m-regular text-primary border-grey" type="text"
                                        placeholder="San Francisco, CA 94101" name="languages_known"
                                        value="<?= $usersData['lang'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-fields__item d-flex flex-column gap-4">
                                <p class="fields-item__title  navigation-label text-primary">Certifications
                                </p>
                                <div class="form-fields__input surface-white">
                                    <input class="body-m-regular text-primary border-grey" type="text"
                                        placeholder="San Francisco, CA 94101" name="certifications"
                                        value="<?= $usersData['certifications'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="user-bio d-flex flex-column gap-16">
                            <h5 class="text-primary">User skills</h5>
                            <p class="text-action"><?= $usersData['skills'] ?></p>
                        </div>

                        <div class="user-bio d-flex flex-column gap-16">
                            <h5 class="text-primary">User description</h5>
                            <textarea class="body-m-regular text-primary border-grey padding-8 border-radius-6" readonly
                                placeholder="bio" name="description" id="" cols="30"
                                rows="10"><?= $usersData['description'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</div>

<?php require_once './partials/site/footer.php'; ?>