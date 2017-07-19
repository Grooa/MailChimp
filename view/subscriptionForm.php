<div class="ipWidget mailchimp-subscription">
    <h3><?=$title?></h3>

    <?php if (!empty($description)): ?>
        <div class="description">
            <?= $description ?>
        </div>
    <?php endif; ?>

    <div class="ipWidget ipWidget-Form"><?= $form->render() ?></div>
</div>