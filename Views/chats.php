<?php require_once './partials/site/header.php'; ?>
<main class="d-flex flex-column gap-40">
    <section class="profile-section">
        <div class="container">
            <div class="profile-section__content profile-content d-flex flex-column gap-40">
                <div class="user-list d-flex flex-column gap-12">
                    <?php foreach ($chats as $chat):?>
                        <div class="user-item surface-white padding-40 border-radius-12">
                            <div class="user-item__header user-header d-flex justify-content-between align-items-center">
                                <h4><?php echo htmlspecialchars($chat['other_user_name']); ?></h4>
                                <a href="/chat?id=<?= $chat['chat_id'] ?>"
                                   class="btn-large padding-bottom surface-action border-radius-12 text-on-action ">Chat</a>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </section>
</main>
</div>
<?php require_once './partials/site/footer.php'; ?>