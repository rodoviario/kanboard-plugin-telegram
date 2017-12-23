<h3><img src="<?= $this->url->dir() ?>plugins/Telegram/telegram-icon.png"/>&nbsp;Telegram</h3>
<div class="panel">
    <?= $this->form->label(t('Chat-id of group chat'), 'telegram_group_cid') ?>
    <?= $this->form->text('telegram_group_cid', $values, array()) ?>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
