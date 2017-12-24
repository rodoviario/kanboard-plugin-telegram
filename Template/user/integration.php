<h3><img src="<?= $this->url->dir() ?>plugins/Telegram/telegram-icon.png"/>&nbsp;Telegram</h3>
<div class="panel">
    <?= $this->form->label(t('Chat id of private chat with bot'), 'telegram_user_cid') ?>
    <?= $this->form->text('telegram_user_cid', $values) ?>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
