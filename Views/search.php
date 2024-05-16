<?php
require_once './partials/site/header.php';
?>
<main class="d-flex flex-column gap-40">
    <section class="profile-section">
        <div class="container">
            <div class="profile-section__content profile-content d-flex flex-column gap-40">
                <div class="profile-content__edit profile-edit d-flex flex-column gap-16">
                    <form action="" method="GET" class="search-form__wrapper d-grid search-form gap-16">
                        <div class="form__skills d-flex gap-8 ">
                            <?php
                            $skills = ['Mobile App Development', 'UI/UX Design', 'Graphic Design', 'Digital Marketing', 'SEO Optimization', 'E-commerce Solutions', 'Content Writing', 'Data Analytics', 'Cloud Computing', 'Cybersecurity'];
                            foreach ($skills as $skill) {
                                echo "<div class='project-type__item'>";
                                echo "<input type='checkbox' name='project-type[]' value='$skill' " . (in_array($skill, $selectedSkills) ? "checked" : "") . ">";
                                echo "<div class='project-type__btn surface-neutral'>";
                                echo "<p class='body-m-regular text-on-action'>$skill</p>";
                                echo "</div>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                        <div class="d-flex gap-24">
                            <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                <p class="body-m-normal">Work schedule</p>
                                <select class="border-grey" name="schedule" id="">
                                    <option value="all" <?php echo ($schedule == 'all') ? 'selected' : ''; ?>>all</option>
                                    <option value="remote" <?php echo ($schedule == 'remote') ? 'selected' : ''; ?>>remote
                                    </option>
                                    <option value="night" <?php echo ($schedule == 'night') ? 'selected' : ''; ?>>night
                                    </option>
                                    <option value="day" <?php echo ($schedule == 'day') ? 'selected' : ''; ?>>day</option>
                                </select>

                            </div>

                            <div class="field-wrapper flex-1  d-flex flex-column gap-4">
                                <p class="body-m-normal">Salary range</p>
                                <div class="d-flex gap-12">
                                    <input type="text" placeholder="from" name="from_price" value="<?= $fromPrice ?>"
                                        class="border-grey">
                                    <input type="text" placeholder="to" name="to_price" class="border-grey "
                                        value="<?= $toPrice ?>">
                                </div>
                            </div>

                            <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                <p class="body-m-normal">Age</p>
                                <select class="border-grey" name="age_user" id="">
                                    <option value="">all</option>
                                    <option value="> 20" <?php echo ($ageFilter == '> 20') ? 'selected' : ''; ?>> > 20
                                    </option>
                                    <option value="20 - 30" <?php echo ($ageFilter == '20 - 30') ? 'selected' : ''; ?>>20
                                        - 30</option>
                                    <option value="30 - 40" <?php echo ($ageFilter == '30 - 40') ? 'selected' : ''; ?>>30
                                        - 40</option>
                                    <option value="40 >" <?php echo ($ageFilter == '40 >') ? 'selected' : ''; ?>>40 >
                                    </option>
                                </select>
                            </div>

                            <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                <p class="body-m-normal">Experience</p>
                                <select class="border-grey" name="experience" id="">
                                    <option value="">all</option>
                                    <option value="> 1" <?php echo ($experienceFilter == '> 1') ? 'selected' : ''; ?>> >1
                                    </option>
                                    <option value="1" <?php echo ($experienceFilter == '1') ? 'selected' : ''; ?>>1
                                    </option>
                                    <option value="2" <?php echo ($experienceFilter == '2') ? 'selected' : ''; ?>>2
                                    </option>
                                    <option value="3" <?php echo ($experienceFilter == '3') ? 'selected' : ''; ?>>3
                                    </option>
                                    <option value="4+" <?php echo ($experienceFilter == '4+') ? 'selected' : ''; ?>>4+
                                    </option>
                                </select>
                            </div>

                            <div class="field-wrapper flex-1 d-flex flex-column gap-4">
                                <p class="body-m-normal">Languages</p>
                                <?php
                                echo '<select id="languages-select" name="languages[]" multiple>';
                                $languages = ['English', 'Ukrainian', 'Spanish'];
                                foreach ($languages as $language) {
                                    $isSelected = in_array($language, $selectedLanguages);
                                    $selectedAttribute = $isSelected ? 'selected' : '';
                                    echo "<option value=\"$language\" $selectedAttribute>$language</option>";
                                }
                                echo '</select>';
                                ?>
                            </div>

                        </div>
                        <div class="search-btn">
                            <button class="btn-large border-radius-12 surface-action text-on-action">Search</button>
                        </div>
                    </form>

                </div>

                <div class="user-list d-flex flex-column gap-12">

                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="user-item surface-white padding-40 border-radius-12">
                            <div class="user-item__header user-header d-flex justify-content-between align-items-center">
                                <div class="user-header__info d-flex align-items-center gap-12">
                                    <a href="/resume_like?id_resume=<?= $row['resume_id'] ?>">
                                        <img src="./assets/img/icon/star-un-active.svg" alt="star-active">
                                    </a>

                                    <div class="d-flex align-items-center gap-12">
                                        <h4>
                                            <?= $row['user_name'] ?>
                                        </h4>
                                        <p class="badge-bold">
                                            Price: <?= $row['from_price'] ?>$/month <br>
                                            Languages: <?= $row['languages'] ?>
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="user-header__skills d-flex align-items-center gap-8 user-skills text-secondary caption-strikethrough">
                                    <?php
                                    $skills = $row['skills'];
                                    $skillsArray = explode(', ', $skills);
                                    foreach ($skillsArray as $index => $skill) {
                                        echo "<p>" . htmlspecialchars($skill) . "</p>";
                                        if ($index < count($skillsArray) - 1) {
                                            echo "<p>•</p>";
                                        }
                                    }
                                    ?>

                                </div>
                                <a href="/info-user?id=<?= $row['user_id'] ?>"
                                    class="btn-large padding-bottom surface-action border-radius-12 text-on-action">Details</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
</main>
    </div>
<?php require_once './partials/site/footer.php'; ?>