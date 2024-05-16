<?php
require_once './partials/site/header.php';
?>

<main>
    <div class="container">
        <div class="auth-form surface-white padding-40 border-radius-12 d-flex flex-column gap-24" action="" method="">
            <h4 class="text-center">Client Chats</h4>
            <p class="auth-form__sub-title navigation-label text-center">
                Here you can offer the <br> candidate terms of cooperation.
            </p>
            <div class="auth-form__fields d-flex flex-column gap-12">

                <div class="chat__wrapper d-flex flex-column gap-8">
                    <!--  -->
                    <div class="chat__wrapper d-flex flex-column gap-8">
                        <?php foreach ($messageList as $message_item): ?>
                           
                            <?php if ($_SESSION['user_id'] == $message_item[2]): ?>
                                <div class="chat-messages-item d-flex justify-content-end">
                                    <p class="user-mess navigation-label padding-8 border-radius-12 surface-disabled">
                                        <?= $message_item[3] ?>
                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="chat-messages-item">
                                    <p class="me-mess navigation-label surface-disabled padding-8 border-radius-12">
                                        <?= $message_item[3] ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <form class="auth-form__field d-flex flex-column gap-8" action="/start_chat" method="post">
                    <input type="hidden" name="chat_id" value="<?php echo $chatId; ?>">
                    <input type="hidden" name="sender_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <input class="border-grey navigation-label" type="text" placeholder="Write a message..."
                        name="message" required>
                    <button class="btn-form btn-large surface-action text-on-action">Send message</button>
                </form>

            </div>
        </div>
    </div>
</main>
</div>
<?php require_once './partials/site/footer.php'; ?>