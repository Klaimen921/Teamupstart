<div class="chat__wrapper d-flex flex-column gap-8">
    <?php foreach ($messageList as $messageItem): ?>
        <?php if ($_SESSION['user_id'] == $messageItem[2]): ?>
            <div class="chat-messages-item d-flex justify-content-end">
                <p class="user-mess navigation-label padding-8 border-radius-12 surface-disabled">
                    <?= $messageItem[3] ?>
                </p>
            </div>
        <?php else: ?>
            <div class="chat-messages-item">
                <p class="me-mess navigation-label surface-disabled padding-8 border-radius-12">
                    <?= $messageItem[3] ?>
                </p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>