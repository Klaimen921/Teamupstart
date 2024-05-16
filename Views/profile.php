<?php
require_once './partials/site/header.php';
?>
<main class="d-flex flex-column gap-40">
    <section class="top-section user">
        <div class="container">
            <div class="user-info__wrapper d-flex align-items-center justify-content-between">
                <div class="d-flex gap-40 align-items-center">
                    <div class="user-info d-flex align-items-center gap-24">
                        <div class="user-info__img d-flex justify-content-center align-items-center">
                            <h3 class="text-on-action text-uppercase"><?= mb_substr($users['name'], 0, 1) ?></h3>
                        </div>
                        <div class="user-info__details">
                            <h4 class="text-primary"><?= $users['name'] ?></h4>
                            <p class="text-primary caption-bold"><?= $users['email'] ?></p>
                        </div>
                    </div>
                </div>

                <a href="/logout" class="user__log-out btn-large text-secondary">
                    Log out
                </a>
            </div>
        </div>
    </section>

    <?php if ($_SESSION['role'] == 'job_seeker'): ?>
        <section class="profile-section">
            <div class="container">
                <div class="profile-section__content profile-content d-flex flex-column gap-40">
                    <div class="profile-content__edit profile-edit d-flex flex-column gap-16">
                        <div class="profile-edit__header d-flex align-items-center gap-16">
                            <img src="../assets/img/icon/edit.svg" alt="edit__icon">
                            <h5 class="text-primary">Create profile</h5>
                            <div>
                                <?php if ($usersData['status'] == 0 && isset($usersData['status'])): ?>
                            <div class="notification verification border-radius-12 padding-16">Ваше резюме знаходиться на перевірці.</div>
                                <?php elseif ($usersData['status'] == 1): ?>
                            <div class="notification false border-radius-12 padding-16">Виправіть помилки у вашому резюме.</div>
                                <?php elseif ($usersData['status'] == 2): ?>
                            <div class="notification true border-radius-12 padding-16">Резюме опубліковано.</div>
                        <?php endif; ?>
                    </div>
                        </div>
                        <form id="myForm" method="post"
                              class="d-flex flex-column gap-40">
                            <div class="form-input__list d-grid profile-edit__form gap-16">

                                <div class="form-fields__item d-flex flex-column gap-4">
                                    <p class="fields-item__title  navigation-label text-primary">Adress</p>
                                    <div class="form-fields__input surface-white">
                                        <input class="body-m-regular text-primary border-grey" type="text"
                                            placeholder="San Francisco, CA 94101" name="adress"
                                            value="<?= $usersData['adress'] ?>">
                                    </div>
                                </div>
                                <div class="form-fields__item d-flex flex-column gap-4">
                                    <p class="fields-item__title  navigation-label text-primary">Education</p>
                                    <div class="form-fields__input surface-white">
                                        <input class="body-m-regular text-primary border-grey" type="text"
                                            placeholder="San Francisco, CA 94101" name="education"
                                            value="<?= $usersData['education'] ?>">
                                    </div>
                                </div>
                                <div class="form-fields__item d-flex flex-column gap-4">
                                    <p class="fields-item__title  navigation-label text-primary">Languages known
                                    </p>
                                    <div class="form-fields__input surface-white">
                                        <input class="body-m-regular text-primary border-grey" type="text"
                                            placeholder="San Francisco, CA 94101" name="languages_known"
                                            value="<?= $usersData['lang'] ?>">
                                    </div>
                                </div>
                                <div class="form-fields__item d-flex flex-column gap-4">
                                    <p class="fields-item__title  navigation-label text-primary">Certifications
                                    </p>
                                    <div class="form-fields__input surface-white">
                                        <input class="body-m-regular text-primary border-grey" type="text"
                                            placeholder="San Francisco, CA 94101" name="certifications"
                                            value="<?= $usersData['certifications'] ?>">
                                    </div>
                                </div>
                            </div>

                            <?php require_once 'partials/skills.php'; ?>

                            <div class="d-flex gap-24">
                                <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                    <p class="body-m-normal">Work schedule</p>

                                    <select class="border-grey" name="schedule" id="">

                                        <option value="all" <?= $usersData['schedule'] == 'all' ? 'selected' : '' ?>>All
                                        </option>
                                        <option value="remote" <?= $usersData['schedule'] == 'remote' ? 'selected' : '' ?>>
                                            Remote</option>
                                        <option value="night" <?= $usersData['schedule'] == 'night' ? 'selected' : '' ?>>Night
                                        </option>
                                        <option value="day" <?= $usersData['schedule'] == 'day' ? 'selected' : '' ?>>Day
                                        </option>
                                    </select>
                                </div>

                                <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                    <p class="body-m-normal">Age</p>
                                    <select class="border-grey" name="age_user" id="">

                                        <option value="> 20" <?= $usersData['age_user'] == '> 20' ? 'selected' : '' ?>> > 20
                                        </option>
                                        <option value="20 - 30" <?= $usersData['age_user'] == '20 - 30' ? 'selected' : '' ?>>
                                            20 - 30</option>
                                        <option value="30 - 40" <?= $usersData['age_user'] == '30 - 40' ? 'selected' : '' ?>>
                                            30 - 40</option>
                                        <option value="40 >" <?= $usersData['age_user'] == '40 >' ? 'selected' : '' ?>>40 >
                                        </option>
                                    </select>
                                </div>
                                <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                    <p class="body-m-normal">Price $</p>
                                    <input type="number" placeholder="1000" name="from_price"
                                        value="<?= $usersData['from_price'] ?>" class="border-grey" required>
                                </div>

                                <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                    <p class="body-m-normal">Experience</p>
                                    <select class="border-grey" name="experience" id="">

                                        <option value="> 1" <?= $usersData['experience'] == '> 1' ? 'selected' : '' ?>> > 1
                                        </option>
                                        <option value="1" <?= $usersData['experience'] == '1' ? 'selected' : '' ?>>1</option>
                                        <option value="2" <?= $usersData['experience'] == '2' ? 'selected' : '' ?>>2</option>
                                        <option value="3" <?= $usersData['experience'] == '3' ? 'selected' : '' ?>>3</option>
                                        <option value="4+" <?= $usersData['experience'] == '4+' ? 'selected' : '' ?>>4+
                                        </option>
                                    </select>
                                </div>

                                <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                    <p class="body-m-normal">Languages</p>

                                    <select id="work-schedule" name="work-schedule[]" multiple>
                                        <!-- Відображаємо значення, збережене у базі даних -->
                                        <option value="English" <?= in_array("English", explode(", ", $usersData['languages'])) ? 'selected' : '' ?>>English</option>
                                        <option value="Ukrainian" <?= in_array("Ukrainian", explode(", ", $usersData['languages'])) ? 'selected' : '' ?>>Ukrainian</option>
                                        <option value="Spanish" <?= in_array("Spanish", explode(", ", $usersData['languages'])) ? 'selected' : '' ?>>Spanish</option>
                                    </select>
                                </div>
                            </div>


                            <div class="user-bio d-flex flex-column gap-16">
                                <h5 class="text-primary">User description</h5>
                                <textarea class="body-m-regular text-primary border-grey" placeholder="bio"
                                    name="description" id="" cols="30"
                                    rows="10"><?= $usersData['description'] ?></textarea>
                            </div>


                            <button class="btn-form btn-large surface-action text-on-action">Save</button>
                        </form>

                    </div>


                </div>
            </div>
        </section>
    <?php else: ?>
        <div class="container-sm d-flex flex-column justify-content-center gap-40 text-center">
            <h3>Welcome to TeamUpStart!</h3>

            <p>
                Welcome to your personal dashboard! Here, you can post job openings and find qualified candidates for your
                team.
                <br><br>
                <b>What you can do in your account:</b>
                <br><br>
                View Candidates: Review the resumes of candidates who have applied for your job openings.
                Communicate with Candidates: Engage in conversations and discuss job details directly with potential
                candidates.
            </p>
            <div class="d-flex justify-content-end">
                <a href="/search" class="text-action">Search</a>
            </div>

        </div>
    <?php endif; ?>
</main>
</div>
<div class="alert-messages">
    <div class="alert-messages__item status-green border-radius-12 padding-24">
        <p class="text-on-action">Data updated successfully</p>
    </div>
</div>

<?php require_once './partials/site/footer.php'; ?>

<script src="../assets/js/script.js"></script>