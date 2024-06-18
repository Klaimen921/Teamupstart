<?php require_once './partials/site/header.php'; ?>
<main class="d-flex flex-column gap-40">
    <section class="profile-section">
        <div class="container">
            <div class="profile-section__content profile-content d-flex flex-column gap-40">
                <div class="user-list d-flex flex-column gap-12">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="user-item surface-white padding-40 border-radius-12">
                            <div class="user-item__header user-header d-flex justify-content-between align-items-center">
                                <div class="user-header__info d-flex align-items-center gap-12">
                                    <img src="./assets/img/icon/star-active.svg" alt="star-active">
                                    <h4><?= htmlspecialchars($row['resume_user_name']) ?></h4>
                                </div>
                                <div
                                    class="user-header__skills d-flex align-items-center gap-8 user-skills text-secondary caption-strikethrough">
                                    <p><?= htmlspecialchars($row['resume_skills']) ?></p>
                                </div>
                                <div class="d-flex gap-8">
                                    <a href="<?php echo $row['unique_new_resume_id'] > 0 ? '/info-user?newResumeId='.$row['unique_new_resume_id']: '/info-user?id='.$row['resume_user_id'] ?>"
                                        class="btn-small padding-bottom surface-action border-radius-12 text-on-action">Details</a>
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'employer'): ?>
                                        <?php if ($row['team_status'] == ''): ?>
                                            <a href="/invite_to_team?id_user=<?= $row['user_id'] ?>"
                                                class="btn-small padding-bottom surface-action border-radius-12 text-on-action">Запросити
                                                до команди</a>
                                        <?php elseif ($row['team_status'] == 1): ?>
                                            <span class="badge badge-success">Запрошення в команду активне</span>
                                        <?php elseif ($row['team_status'] == -1): ?>
                                            <span class="badge badge-success">Відмова</span>
                                        <?php elseif ($row['team_status'] == 2): ?>
                                            <span class="badge badge-success">Очікується відповідь</span>
                                        <?php endif; ?>
                                    <?php endif ?>
                                </div>
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