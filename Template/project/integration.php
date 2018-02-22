<h3><img src="<?= $this->url->dir() ?>plugins/Telegram/telegram-icon.png"/>&nbsp;Telegram</h3>
    <?php $random = md5(time().$this->url->base().rand()) ?>

    <p>Please send following message to the bot: <?= $random ?><br/>
    then press <?= $this->modal->medium('none', t('Get chat id'), 'TelegramController', 'get_project_chat_id',array('plugin' => 'Telegram', 'private_message' => $random,'project_id' => $project['id'] ) ) ?>

<div class="panel">
    <?= $this->form->label(t('Chat id of group chat with bot'), 'telegram_group_cid') ?>
    <?= $this->form->text('telegram_group_cid', $values, array()) ?>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
