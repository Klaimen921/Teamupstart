<?php require_once './partials/site/header.php'; ?>
<main>
    <div class="container">
        <div class="auth-form surface-white padding-40 border-radius-12 d-flex flex-column gap-24" action="" method="">
            <h4 class="text-center">Client Chats</h4>
            <p class="auth-form__sub-title navigation-label text-center">
                Here you can offer the <br> candidate terms of cooperation.
            </p>
            <div class="auth-form__fields d-flex flex-column gap-12">
                <div class="chat__wrapper d-flex flex-column gap-8">
                    <?php require_once './partials/chat.php'?>
                </div>
                <form class="auth-form__field d-flex flex-column gap-8 send-message" method="post">
                    <input type="hidden" name="chat_id" value="<?php echo $chatId; ?>">
                    <input type="hidden" name="sender_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <input id="write_message" class="border-grey navigation-label" type="text" placeholder="Write a message..."
                        name="message" required>
                    <button class="btn-form btn-large surface-action text-on-action">Send message</button>
                </form>

            </div>
        </div>
    </div>
</main>
</div>
<div class="alert-messages">
    <div class="alert-messages__item status-green border-radius-12 padding-24">
        <p class="text-on-action"></p>
    </div>
</div>
<?php require_once './partials/site/footer.php'; ?>

<script src="../assets/js/chat.js"></script>
