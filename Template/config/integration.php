<h3><img src="<?= $this->url->dir() ?>plugins/Telegram/telegram-icon.png"/>&nbsp;Telegram</h3>
<div class="panel">
    <?= $this->form->label(t('Telegram bot username'), 'telegram_username') ?>
    <?= $this->form->text('telegram_username', $values, array()) ?>

    <?= $this->form->label(t('Telegram bot API key'), 'telegram_apikey') ?>
    <?= $this->form->text('telegram_apikey', $values, array()) ?>

    <p class="form-help"><a href="https://core.telegram.org/bots" target="_blank"><?= t('Help on how to generate a bot') ?></a></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
